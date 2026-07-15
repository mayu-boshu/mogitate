<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    // 💡【追加】季節は複数の商品を持つ（多対多のリレーション）
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}