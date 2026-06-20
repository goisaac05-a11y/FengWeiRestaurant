<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Cart;
use App\Models\Order;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        // Gate 1: Allow both logged-in users and guests to view order history
        Gate::define('view-order-history', function ($user = null) {
            return true;
        });

        // Gate 2: Only the cart item owner can modify or delete it
        Gate::define('modify-cart-item', function ($user, Cart $cartItem) {
            if ($user) {
                return $cartItem->user_id === $user->id;
            }
            return $cartItem->session_id === session()->getId();
        });

        // Gate 3: Only the order owner can view the order
        Gate::define('view-order', function ($user, Order $order) {
            return $order->user_id === $user->id;
        });

        // Gate 4: Admin only — checks role field in users table
        Gate::define('admin-only', function ($user) {
            return $user->role === 'admin';
        });
    }
}