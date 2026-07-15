<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest; // 💡 作成したProductRequestを使うために追加
use App\Models\Product;
use App\Models\Season; // 💡 検索の選択肢として季節一覧を出すために追加
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 商品一覧画面を表示する（検索機能付き）
     */
    public function index(Request $request)
    {
        // 1. 💡 ブラウザから送られてきた検索パラメータ（入力値）を受け取る
        $keyword = $request->input('keyword'); // 商品名のキーワード
        $seasonId = $request->input('season_id'); // 選択された季節のID

        // 2. 💡 クエリの土台を作る（まだデータベースに命令は送らない）
        $query = Product::with('seasons');

        // 3. 💡 もしキーワードが入力されていたら、商品名で「部分一致検索」をする
        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        // 4. 💡 もし季節が選択されていたら、中間テーブルを辿って絞り込む
        if (!empty($seasonId)) {
            $query->whereHas('seasons', function ($q) use ($seasonId) {
                $q->where('seasons.id', $seasonId);
            });
        }

        // 5. 💡 最終的なクエリ（命令）を実行してデータを取得
        $products = $query->get();

        // 6. 💡 検索フォーム用の「季節一覧」も取得しておく
        $seasons = Season::all();

        // 💡 ビューに変数（商品一覧、季節一覧、現在の入力値）を渡す
        return view('products.index', compact('products', 'seasons', 'keyword', 'seasonId'));
    }
    /**
     * 商品詳細画面を表示する
     */
    public function show($id)
    {
        // 💡 指定されたIDの商品を1件だけデータベースから探します
        // findOrFail を使うと、もし存在しないID（例: 999）が指定された時に、
        // 自動的に「404 Not Found（ページが見つかりません）」エラー画面を出してくれます。
        $product = Product::with('seasons')->findOrFail($id);

        // 💡 取得した1件の商品データを `show` という名前の画面（ビュー）に渡します
        return view('products.show', compact('product'));
    }
    /**
     * 商品新規登録画面を表示する
     */
    public function create()
    {
        // 💡 登録画面のチェックボックスで選べるように、すべての季節データを取得します
        $seasons = Season::all();

        // 💡 取得した季節データを登録画面（createビュー）に渡します
        return view('products.create', compact('seasons'));
    }
    /**
     * 商品をデータベースに保存する
     */
    public function store(ProductRequest $request) // 💡 さきほど作った ProductRequest で自動チェック！
    {
        // 1. 💡 画像ファイルのアップロード処理
        // アップロードされた画像を 'public/products' フォルダに保存し、そのファイル名を取得します
        if ($request->hasFile('image')) {
            // 元のファイル名を取得して保存（またはLaravelにランダムな名前で保存させることも可能）
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 2. 💡 商品データの作成と保存
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->image = $imagePath; // 保存した画像のパス
        $product->description = $request->input('description');
        $product->save(); // データベースに保存！

        // 3. 💡 中間テーブル（季節の紐付け）の保存
        // $request->input('seasons') には [1, 2] のような選択された季節のID配列が入っています
        // sync メソッドを使うと、中間テーブルに自動で一括登録してくれます。超便利！
        $product->seasons()->sync($request->input('seasons'));

        // 4. 💡 一覧画面にリダイレクト（戻す）
        // その際、画面に「登録しました！」という緑のメッセージを出すためにフラッシュセッションを渡します
        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }
    /**
     * 商品編集画面を表示する
     */
    public function edit($id)
    {
        // 💡 編集する商品を1件取得
        $product = Product::with('seasons')->findOrFail($id);

        // 💡 選択肢として使う季節一覧を取得
        $seasons = Season::all();

        return view('products.edit', compact('product', 'seasons'));
    }

    /**
     * 商品データを更新する
     */
    public function update(ProductRequest $request, $id) // 💡 新規登録で作った ProductRequest をここでも再利用して自動チェック！
    {
        $product = Product::findOrFail($id);

        // 1. 💡 画像ファイルの更新処理（新しい画像が選択された場合のみ）
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // 2. 💡 その他の情報を上書き保存
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        // 3. 💡 中間テーブル（季節の紐付け）も更新
        $product->seasons()->sync($request->input('seasons'));

        // 4. 💡 詳細画面に戻り、メッセージを表示
        return redirect()->route('products.show', $product->id)->with('success', '商品を更新しました！');
    }
    /**
     * 商品をデータベースから削除する
     */
    public function destroy($id)
    {
        // 1. 💡 削除する対象の商品を取得
        $product = Product::findOrFail($id);

        // 2. 💡 中間テーブルの紐付けを安全に解除（これをしないとエラーになることがあります）
        $product->seasons()->detach();

        // 3. 💡 商品データを削除！
        $product->delete();

        // 4. 💡 一覧画面に戻り、「削除しました」というメッセージを伝える
        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}