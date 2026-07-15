<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>もぎたて - 商品編集</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 text-gray-800 min-h-screen">

    <header class="bg-white shadow-sm">
        <div class="max-w-2xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-600">もぎたて</h1>
            <a href="{{ route('products.show', $product->id) }}" class="text-gray-600 hover:text-orange-600 font-bold transition">
                &larr; 詳細に戻る
            </a>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 border-b pb-2">商品編集</h2>

            {{-- 💡 エラーメッセージ表示 --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                    <ul class="list-disc pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 💡 更新は method="POST" にしつつ、下で @method('PUT') を指定するのがLaravelのルールです --}}
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT') {{-- 💡 これでLaravelに「これはPUT（更新）通信だよ」と伝えます --}}

                <!-- 商品名 -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">商品名 <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $product->name) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                </div>

                <!-- 価格 -->
                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 mb-1">価格 <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" required value="{{ old('price', $product->price) }}" min="0"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                </div>

                <!-- 商品画像 -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">現在の画像</label>
                    <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden mb-2">
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="現在の画像" class="w-full h-full object-cover">
                    </div>
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-1">新しい画像に変更（任意）</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                </div>

                <!-- 季節（複数選択） -->
                <div>
                    <span class="block text-sm font-bold text-gray-700 mb-2">季節 <span class="text-red-500">*</span></span>
                    <div class="flex gap-4">
                        @foreach($seasons as $season)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="seasons[]" value="{{ $season->id }}" 
                                       {{ in_array($season->id, old('seasons', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $season->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 商品説明 -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">商品説明 <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="4" required
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- ボタンエリア -->
                <div class="pt-4 flex gap-4">
                    <a href="{{ route('products.show', $product->id) }}" class="w-1/2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center font-bold py-2 px-4 rounded-md transition block">
                        キャンセル
                    </a>
                    <button type="submit" class="w-1/2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-md transition shadow">
                        更新する
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>