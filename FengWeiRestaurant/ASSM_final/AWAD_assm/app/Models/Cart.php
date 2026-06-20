<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;
    
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'image_url',
    ];

    // ==========================================
    // Relationships
    // ==========================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}