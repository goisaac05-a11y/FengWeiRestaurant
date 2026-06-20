<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; 
    
    protected $fillable = [
        'user_id',
        'session_id',
        'total',
    ];

    // ==========================================
    // Relationships
    // ==========================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}