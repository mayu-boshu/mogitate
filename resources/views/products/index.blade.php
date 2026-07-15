<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>もぎたて - 商品一覧</title>
    <!-- 💡 後でデザインを整えやすいよう、シンプルなCSS（Tailwind CSSなど）が使えるようにしておきます -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-amber-50 text-gray-800 min-h-screen">

    <!-- 💡 ヘッダー部分（共通デザインになる部分） -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-600">もぎたて</h1>
            <header class="bg-white shadow-sm">
                <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-orange-600">もぎたて</h1>
                    <a href="{{ route('products.create') }}"
                        class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-md transition shadow text-sm">
                        + 商品を登録する
                    </a>
                </div>
            </header>
        </div>
    </header>

    <!-- 💡 メインコンテンツ領域 -->
    <main class="max-w-6xl mx-auto px-4 py-8">

        <!-- 💡 登録・編集・削除に成功した時のサクセスメッセージ表示エリア -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center"
                id="success-alert">
                <span class="font-bold">{{ session('success') }}</span>
                <button onclick="document.getElementById('success-alert').remove()"
                    class="text-green-700 hover:text-green-900 font-bold">×</button>
            </div>
        @endif

        <h2 class="text-xl font-bold mb-6 border-b-2 border-orange-200 pb-2">商品一覧</h2>
        <!-- 💡 検索フォーム（追加部分） -->
        <form action="{{ route('products.index') }}" method="GET"
            class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">

            <!-- キーワード入力 -->
            <div class="flex-1 w-full">
                <label for="keyword" class="block text-sm font-medium text-gray-700 mb-1">商品名で検索</label>
                <input type="text" name="keyword" id="keyword" value="{{ $keyword }}" placeholder="例: キウイ"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
            </div>

            <!-- 季節の選択（セレクトボックス） -->
            <div class="w-full md:w-48">
                <label for="season_id" class="block text-sm font-medium text-gray-700 mb-1">季節で絞り込み</label>
                <select name="season_id" id="season_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                    <option value="">すべて</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season->id }}" {{ $seasonId == $season->id ? 'selected' : '' }}>
                            {{ $season->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 検索ボタン / クリアボタン -->
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit"
                    class="w-full md:w-auto bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-md transition shadow">
                    検索
                </button>
                <a href="{{ route('products.index') }}"
                    class="w-full md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 text-center font-bold py-2 px-4 rounded-md transition">
                    クリア
                </a>
            </div>
        </form>

        <!-- 💡 商品カードのグリッドレイアウト（レスポンシブ対応） -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <!-- 💡 個別の商品カード（高さを h-full で統一し、flex-col で整列） -->
                <a href="{{ route('products.show', ['id' => $product->id]) }}" class="block group">
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition flex flex-col h-[420px]">
                        <!-- 💡 商品画像（高さを 48（12rem）に固定し、枠内に綺麗に収める） -->
                        <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <!-- 💡 商品情報（全体を flex で囲み、余白を自動分配して高さを揃える） -->
                        <div class="p-4 flex flex-col flex-1 justify-between">
                            <div>
                                <!-- 商品名 -->
                                <h3 class="text-lg font-bold mb-1 text-gray-800 line-clamp-1">{{ $product->name }}</h3>
                                
                                <!-- 価格 -->
                                <p class="text-orange-600 font-extrabold text-lg mb-2">¥{{ number_format($product->price) }}</p>
                                
                                <!-- 季節タグ -->
                                <div class="flex flex-wrap gap-1 mb-2">
                                    @foreach($product->seasons as $season)
                                        <span class="bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded font-medium">
                                            {{ $season->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <!-- 商品説明（line-clamp-3 で3行に収め、はみ出た分は「...」にして高さを一定にする） -->
                            <p class="text-gray-500 text-xs line-clamp-3 leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
    </main>

</body>

</html>