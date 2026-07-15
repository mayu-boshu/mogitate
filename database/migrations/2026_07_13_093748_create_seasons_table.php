<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $blueprint) {
            $blueprint->id(); // bigint unsigned / PRIMARY KEY
            $blueprint->string('name', 255); // 季節名
            $blueprint->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};