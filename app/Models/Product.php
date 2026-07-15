<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 💡【追加】商品は複数の季節を持つ（多対多のリレーション）
    public function seasons()
    {
        // belongsToMany（〜に属する・多数）を使うことで、
        // Laravelが自動的に「product_season」という中間テーブルを探して紐づけてくれます。
        return $this->belongsToMany(Season::class);
    }
}
