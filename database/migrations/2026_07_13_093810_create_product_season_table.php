<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_season', function (Blueprint $blueprint) {
            $blueprint->id(); // bigint unsigned / PRIMARY KEY

            // 外部キー制約（productsテーブルのidに紐付け、親が消えたら一緒に消える設定）
            $blueprint->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // 外部キー制約（seasonsテーブルのidに紐付け、親が消えたら一緒に消える設定）
            $blueprint->foreignId('season_id')->constrained('seasons')->onDelete('cascade');

            $blueprint->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_season');
    }
};