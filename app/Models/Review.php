<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Review dimiliki oleh satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Review dibuat oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
