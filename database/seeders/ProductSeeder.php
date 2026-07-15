<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. 商品データの定義
        $products = [
            [
                'id' => 1,
                'name' => 'キウイ',
                'price' => 800,
                'image' => 'kiwi.png',
                'description' => 'キウイは甘みと酸味のバランスが絶妙なフルーツです。ビタミンCなどの栄養素も豊富のため、美肌効果や疲労回復効果も期待できます。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [3, 4], // 秋、冬
            ],
            [
                'id' => 2,
                'name' => 'ストロベリー',
                'price' => 1200,
                'image' => 'strawberry.png',
                'description' => '大人から子供まで大人気のストロベリー。当店では鮮度抜群の完熟いちごを使用しています。ビタミンCはもちろん食物繊維も豊富なため、腸内環境の改善も期待できます。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [1], // 春
            ],
            [
                'id' => 3,
                'name' => 'オレンジ',
                'price' => 850,
                'image' => 'orange.png',
                'description' => '当店では酸味と甘みのバランスが抜群のネーブルオレンジを使用しています。酸味は控えめで、甘さと濃厚な果汁が魅力の商品です。もぎたてフルーツのスムージをお召し上がりください！',
                'seasons' => [4], // 冬
            ],
            [
                'id' => 4,
                'name' => 'スイカ',
                'price' => 700,
                'image' => 'watermelon.png',
                'description' => '甘くてシャリシャリ食感が魅力のスイカ。全体の90％が水分のため、暑い日の水分補給や熱中症予防、カロリーが気になる方にもおすすめの商品です。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2], // 夏
            ],
            [
                'id' => 5,
                'name' => 'ピーチ',
                'price' => 1000,
                'image' => 'peach.png',
                'description' => '豊潤な香りととろけるような甘さが魅力のピーチ。美味しさはもちろん見た目の可愛さも抜群の商品です。ビタミンEが豊富なため、生活習慣病の予防にもおすすめです。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2], // 夏
            ],
            [
                'id' => 6,
                'name' => 'シャインマスカット',
                'price' => 1400,
                'image' => 'muscat.png',
                'description' => '爽やかな香りと上品な甘みが特長的なシャインマスカットは大人から子どもまで大人気のフルーツです。疲れた脳や体のエネルギー補給にも最適の商品です。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2, 3], // 夏、秋
            ],
            [
                'id' => 7,
                'name' => 'パイナップル',
                'price' => 800,
                'image' => 'pineapple.png',
                'description' => '甘酸っぱさとトロピカルな香りが特徴のパイナップル。当店では甘さと酸味のバランスが絶妙な国産のパイナップルを使用しています。もぎたてフルーツのスムージをお召し上がりください！',
                'seasons' => [1, 2], // 春、夏
            ],
            [
                'id' => 8,
                'name' => 'ブドウ',
                'price' => 1100,
                'image' => 'grapes.png',
                'description' => 'ブドウの中でも人気の高い国産の「巨峰」を使用しています。高い糖度と適度な酸味が魅力で、鮮やかなパープルで見た目も可愛い商品です。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2, 3], // 夏、秋
            ],
            [
                'id' => 9,
                'name' => 'バナナ',
                'price' => 600,
                'image' => 'banana.png',
                'description' => '低カロリーでありながら栄養満点のため、ダイエット中の方にもおすすめの商品です。1杯でバナナの濃厚な甘みを存分に堪能できます。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2], // 夏
            ],
            [
                'id' => 10,
                'name' => 'メロン',
                'price' => 900,
                'image' => 'melon.png',
                'description' => '香りがよくジューシーで品のある甘さが人気のメロンスムージー。カリウムが多く含まれているためむくみ解消効果も抜群です。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [1, 2], // 春、夏
            ],
        ];

        // 2. データの挿入
        foreach ($products as $product) {
            // productsテーブルに挿入
            DB::table('products')->insert([
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'description' => $product['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 中間テーブル（product_season）に挿入
            foreach ($product['seasons'] as $seasonId) {
                DB::table('product_season')->insert([
                    'product_id' => $product['id'],
                    'season_id' => $seasonId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
