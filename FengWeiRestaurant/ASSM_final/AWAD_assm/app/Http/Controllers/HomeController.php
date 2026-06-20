<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class HomeController extends Controller
{
    // ==========================================
    // Get cart total quantity
    // ==========================================
    private function getCartTotalItems()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }
        return Cart::where('session_id', session()->getId())->sum('quantity');
    }

    // ==========================================
    // Home Page
    // ==========================================
    public function index()
    {
        // Eloquent ORM: get 4 random chicken/pork specials
        $specials = Product::whereIn('category', ['chicken', 'pork'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $cartTotalItems = $this->getCartTotalItems();

        // Requirement 7: Track last visit using session
        $lastVisit = session('last_visit');
        session(['last_visit' => now()->toDateTimeString()]);

        return view('home', compact('specials', 'cartTotalItems', 'lastVisit'));
    }
}