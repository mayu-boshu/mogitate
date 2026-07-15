<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>もぎたて - {{ $product->name }} の詳細</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-amber-50 text-gray-800 min-h-screen">

    <header class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-600">もぎたて</h1>
            <!-- 一覧に戻るボタン -->
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-orange-600 font-bold transition">
                &larr; 一覧に戻る
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <main class="max-w-4xl mx-auto px-4 py-8">
            {{-- 💡 更新に成功した時のメッセージ表示 --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center"
                    id="success-alert">
                    <span class="font-bold">{{ session('success') }}</span>
                    <button onclick="document.getElementById('success-alert').remove()"
                        class="text-green-700 hover:text-green-900 font-bold">×</button>
                </div>
            @endif
            <div class="bg-white rounded-lg shadow-md overflow-hidden p-6 md:p-8 flex flex-col md:flex-row gap-8">

                <!-- 左側：商品画像 -->
                <div
                    class="w-full md:w-1/2 h-64 md:h-96 bg-gray-100 flex items-center justify-center rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover">
                </div>

                <!-- 右側：商品の詳細情報 -->
                <div class="w-full md:w-1/2 flex flex-col justify-between">
                    <div>
                        <!-- 季節タグ -->
                        <div class="flex gap-2 mb-4">
                            @foreach($product->seasons as $season)
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">
                                    {{ $season->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- 商品名 -->
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>

                        <!-- 価格 -->
                        <p class="text-2xl font-extrabold text-orange-600 mb-6">¥{{ number_format($product->price) }}
                        </p>

                        <!-- 商品説明 -->
                        <h3 class="text-lg font-bold text-gray-700 mb-2">商品紹介</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- ボタンエリア（修正） -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                        <!-- 左側：編集ボタン -->
                        <a href="{{ route('products.edit', $product->id) }}"
                            class="bg-orange-600 hover:bg-orange-700 text-white text-center font-bold py-2 px-6 rounded-md transition shadow">
                            編集する
                        </a>

                        <!-- 右側：削除ボタン（安全なフォーム形式） -->
                        <!-- onsubmit を仕込むことで、押した瞬間にブラウザの確認ダイアログを出します -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                            onsubmit="return confirm('本当にこの商品を削除してもよろしいですか？');">
                            @csrf
                            @method('DELETE') {{-- 💡 これでLaravelに「DELETE通信だよ」と伝えます --}}
                            <button type="submit"
                                class="bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2 px-4 rounded-md transition border border-red-200">
                                この商品を削除する
                            </button>
                        </form>
                    </div>
                </div>
        </main>

</body>

</html>