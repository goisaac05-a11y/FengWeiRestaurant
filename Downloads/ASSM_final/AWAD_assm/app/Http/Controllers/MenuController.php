<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class MenuController extends Controller
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
    // Menu Index
    // ==========================================
    public function index()
    {
        $categories = Product::all()->groupBy(function ($product) {
            return ucfirst($product->category);
        });

        $cartTotalItems = $this->getCartTotalItems();

        return view('menu.index', compact('categories', 'cartTotalItems'));
    }

    // ==========================================
    // Product Detail Page
    // ==========================================
    public function show($id)
    {
        // Eloquent ORM: find or 404
        $product = Product::findOrFail($id);

        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        $cartTotalItems = $this->getCartTotalItems();

        return view('menu.details', compact('product', 'relatedProducts', 'cartTotalItems'));
    }
}