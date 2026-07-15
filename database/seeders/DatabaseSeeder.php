<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 順番が大事です（親テーブルのSeasonを先にいれる）
        $this->call([
            SeasonSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
