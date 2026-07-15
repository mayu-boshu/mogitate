<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $blueprint) {
            $blueprint->id(); // bigint unsigned / PRIMARY KEY
            $blueprint->string('name', 255); // 商品名
            $blueprint->integer('price'); // 商品料金
            $blueprint->string('image', 255); // 商品画像
            $blueprint->text('description'); // 商品説明
            $blueprint->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};