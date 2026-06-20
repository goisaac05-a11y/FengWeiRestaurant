<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'order_id',
        'query_type',
        'message',
    ];
    public $timestamps = false;

    // ==========================================
    // Relationships
    // ==========================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}