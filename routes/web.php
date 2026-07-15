<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// 1. 商品一覧画面のルート
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 💡 3. 商品新規登録画面のルート（必ず詳細ルートより上に書く！）
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// 2. 商品詳細画面のルート 💡
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// 💡 4. 商品編集画面の表示ルート
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// 💡 5. 商品の更新処理ルート（PUT送信）
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// 💡 商品新規登録の「保存」ルート（POST送信）
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// 💡 6. 商品の削除処理ルート（DELETE送信）
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');