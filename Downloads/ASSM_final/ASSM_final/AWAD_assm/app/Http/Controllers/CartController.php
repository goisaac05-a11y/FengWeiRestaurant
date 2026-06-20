<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CartController extends Controller
{
    // ==========================================
    // Get identifier for guest/user cart
    // ==========================================
    private function getIdentifier()
    {
        if (Auth::check()) {
            return ['column' => 'user_id', 'value' => Auth::id()];
        }
        return ['column' => 'session_id', 'value' => session()->getId()];
    }

    // ==========================================
    // 1. Add to Cart
    // ==========================================
    public function store(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($id);
        $identifier = $this->getIdentifier();

        $cartItem = Cart::where('product_id', $product->id)
            ->where($identifier['column'], $identifier['value'])
            ->first();

        if ($cartItem) {
            // UPDATE quantity if already in cart
            $cartItem->increment('quantity', $request->input('quantity', 1));
        } else {
            // CREATE new cart item
            Cart::create([
                'user_id'    => Auth::check() ? Auth::id() : null,
                'session_id' => session()->getId(),
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => $request->input('quantity', 1),
                'image_url'  => $product->image_url,
            ]);
        }

        return redirect()->route('menu.index')->with('success', 'Item added to cart!');
    }

    // ==========================================
    // 2. View Cart
    // ==========================================
    public function index()
    {
        $identifier = $this->getIdentifier();

        $cartItems = Cart::where($identifier['column'], $identifier['value'])->get();

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $hasOrders = Auth::check()
            ? Order::where('user_id', Auth::id())->exists()
            : count(session('guest_orders', [])) > 0;

        return view('cart.index', [
            'cart_items' => $cartItems,
            'subtotal'   => $subtotal,
            'total'      => $subtotal,
            'cart_empty' => $cartItems->isEmpty(),
            'has_orders' => $hasOrders,
        ]);
    }

    // ==========================================
    // 3. Update Cart Quantity
    // ==========================================
    public function update(Request $request)
    {
        $request->validate([
            'cart_id'  => 'required|integer|exists:cart,id',
            'quantity' => 'required|integer|min:1|max:99',
            'action'   => 'nullable|string|in:increase,decrease',
        ]);

        $identifier = $this->getIdentifier();

        $cartItem = Cart::where('id', $request->cart_id)
            ->where($identifier['column'], $identifier['value'])
            ->firstOrFail();

        if ($request->action === 'increase') {
            $cartItem->increment('quantity');
        } elseif ($request->action === 'decrease' && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->update(['quantity' => max(1, (int) $request->quantity)]);
        }

        return redirect()->route('cart.index');
    }

    // ==========================================
    // 4. Remove Cart Item
    // ==========================================
    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|integer|exists:cart,id',
        ]);

        $identifier = $this->getIdentifier();

        $cartItem = Cart::where('id', $request->cart_id)
            ->where($identifier['column'], $identifier['value'])
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->route('cart.index');
    }

    // ==========================================
    // 5. Checkout
    // ==========================================
    public function checkout(Request $request)
    {
        $identifier = $this->getIdentifier();

        $cartItems = Cart::where($identifier['column'], $identifier['value'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        if (Auth::check()) {
            DB::transaction(function () use ($identifier, $cartItems, $total) {
                // Eloquent ORM: create order
                $order = Order::create([
                    'user_id'    => Auth::id(),
                    'session_id' => session()->getId(),
                    'total'      => $total,
                ]);

                foreach ($cartItems as $item) {
                    $itemData = [
                        'product_id' => $item->product_id,
                        'name'       => $item->name,
                        'price'      => $item->price,
                        'quantity'   => $item->quantity,
                    ];

                    if (Schema::hasColumn('order_items', 'size')) {
                        $itemData['size'] = $item->size ?? null;
                    }
                    if (Schema::hasColumn('order_items', 'add_ons')) {
                        $itemData['add_ons'] = $item->add_ons ?? null;
                    }

                    $order->items()->create($itemData);
                }

                // Delete all cart items for this user/session
                Cart::where($identifier['column'], $identifier['value'])->delete();
            });
        } else {
            $guestOrders = session('guest_orders', []);

            $guestOrders[] = [
                'id' => count($guestOrders) + 1,
                'total' => $total,
                'created_at' => now()->toDateTimeString(),
                'items' => $cartItems->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                    ];
                })->toArray(),
            ];

            session(['guest_orders' => $guestOrders]);

            Cart::where($identifier['column'], $identifier['value'])->delete();
        }

        return view('cart.checkout_success');
    }

    // ==========================================
    // 6. Order History
    // ==========================================
    public function history()
    {
        Gate::authorize('view-order-history');

        if (Auth::check()) {
            $orders = Order::where('user_id', Auth::id())
                ->with('items')
                ->orderBy('created_at', 'desc')
                ->get();

            $orders->each(function ($order) {
                $order->items_summary = $order->items
                    ->map(fn($item) => $item->name . ' (x' . $item->quantity . ')')
                    ->implode(', ');
            });
        } else {
            $orders = collect(session('guest_orders', []));

            $orders = $orders->map(function ($order) {
                $normalizedItems = collect($order['items'] ?? [])->map(function ($item) {
                    return (object) $item;
                });

                return (object) array_merge([
                    'id' => null,
                    'created_at' => now()->toDateTimeString(),
                    'items' => $normalizedItems,
                ], $order);
            });
        }

        return view('cart.history', compact('orders'));
    }
}