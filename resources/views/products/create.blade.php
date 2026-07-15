<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>もぎたて - 商品登録</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 text-gray-800 min-h-screen">

    <header class="bg-white shadow-sm">
        <div class="max-w-2xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-600">もぎたて</h1>
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-orange-600 font-bold transition">
                &larr; 一覧に戻る
            </a>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 border-b pb-2">商品登録</h2>

            {{-- 💡 入力エラーがある場合に表示する赤い警告エリア --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                    <ul class="list-disc pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 💡 送信先を route('products.store')、送信方法を POST に確実設定 --}}
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf {{-- 💡 CSRF保護トークン --}}

                <!-- 商品名 -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">商品名 <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="例: キウイ"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                </div>

                <!-- 価格 -->
                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 mb-1">価格 <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" required value="{{ old('price') }}" placeholder="例: 800" min="0"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                </div>

                <!-- 商品画像 -->
                <div>
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-1">商品画像 <span class="text-red-500">*</span></label>
                    <input type="file" name="image" id="image" required accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                </div>

                <!-- 季節（複数選択チェックボックス） -->
                <div>
                    <span class="block text-sm font-bold text-gray-700 mb-2">季節 <span class="text-red-500">*</span></span>
                    <div class="flex gap-4">
                        @foreach($seasons as $season)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="seasons[]" value="{{ $season->id }}" 
                                       {{ is_array(old('seasons')) && in_array($season->id, old('seasons')) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $season->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 商品説明 -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">商品説明 <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="4" required placeholder="商品の説明を入力してください"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">{{ old('description') }}</textarea>
                </div>

                <!-- ボタンエリア -->
                <div class="pt-4 flex gap-4">
                    <a href="{{ route('products.index') }}" class="w-1/2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center font-bold py-2 px-4 rounded-md transition block">
                        戻る
                    </a>
                    <button type="submit" class="w-1/2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-md transition shadow">
                        登録する
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
