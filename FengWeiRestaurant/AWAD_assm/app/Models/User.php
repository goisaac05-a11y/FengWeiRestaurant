<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'username',
        'email',
        'password',
        'countryCode',
        'phoneNumber',
        'created_at',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }
}