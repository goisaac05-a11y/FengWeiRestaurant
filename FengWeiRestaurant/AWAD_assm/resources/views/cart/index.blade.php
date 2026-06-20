<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>
    <x-header data="Cart" />
    <x-navigation />

    <div class="back-to-home">
        <a href="{{ route('menu.index') }}" class="back-button">← Back to Menu</a>
    </div>

    <div class="page-header">
        <h1>Your Shopping Cart</h1>
        @if(!$cart_empty)
            <p>{{ count($cart_items) }} items in your cart</p>
        @endif
    </div>

    <div class="cart-container">
        @if($cart_empty)
            <div class="empty-cart">
                <img src="{{ asset('icon/cart_.png') }}" alt="Empty Cart" style="width: 64px; opacity: 0.5; margin-bottom: 1rem;">
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any items yet.</p>
                <a href="{{ route('menu.index') }}" class="continue-shopping" style="display: inline-block; margin-top: 1rem;">
                    Start Ordering
                </a>
                @if($has_orders)
                    <br><br>
                    <a href="{{ route('orders.history') }}" class="history-btn">View Previous Orders</a>
                @endif
            </div>
        @else
            <div class="cart-items">
                {{-- Header row --}}
                <div class="cart-header">
                    <span>Product</span>
                    <span>Price</span>
                    <span>Quantity</span>
                    <span>Total</span>
                </div>

                @foreach($cart_items as $product)
                <div class="cart-item">
                    {{-- Column 1: Product details --}}
                    <div class="item-details">
                        <img src="{{ asset($product->image_url) }}"
                             alt="{{ $product->name }}"
                             class="item-image"
                             onerror="this.src='{{ asset('icon/food.png') }}'">
                        <div class="item-info">
                            <h4>{{ $product->name }}</h4>
                            @if($product->size)
                                <div class="item-options">Size: {{ $product->size }}</div>
                            @endif
                            @if($product->add_ons)
                                <div class="item-options">Add-ons: {{ $product->add_ons }}</div>
                            @endif
                            {{-- Remove button sits under product name --}}
                            <form method="POST" action="{{ route('cart.remove') }}" style="display: inline;">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $product->id }}">
                                <button type="submit" class="remove-btn">Remove</button>
                            </form>
                        </div>
                    </div>

                    {{-- Column 2: Unit price --}}
                    <div class="item-price">
                        RM{{ number_format($product->price, 2) }}
                    </div>

                    {{-- Column 3: Quantity controls --}}
                    <div class="quantity-control">
                        <form method="POST" action="{{ route('cart.update') }}" style="display: flex; align-items: center; gap: 0.5rem;">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $product->id }}">
                            <button type="submit" name="action" value="decrease"
                                    class="quantity-btn"
                                    {{ $product->quantity <= 1 ? 'disabled' : '' }}>−</button>
                            <input type="number" name="quantity"
                                   value="{{ $product->quantity }}"
                                   class="quantity-input"
                                   min="1" readonly>
                            <button type="submit" name="action" value="increase"
                                    class="quantity-btn">+</button>
                        </form>
                    </div>

                    {{-- Column 4: Line total --}}
                    <div class="item-total">
                        RM{{ number_format($product->price * $product->quantity, 2) }}
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Order Summary sidebar --}}
            <div class="order-summary">
                <h3 class="summary-title">Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal ({{ count($cart_items) }} items)</span>
                    <span>RM{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>RM{{ number_format($total, 2) }}</span>
                </div>

                <form method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                </form>

                @if($has_orders)
                    <a href="{{ route('orders.history') }}" class="history-btn"
                       style="display: block; text-align: center; margin-top: 1rem;">
                        View Order History
                    </a>
                @endif

                <a href="{{ route('menu.index') }}" class="continue-shopping"
                   style="display: block; text-align: center; margin-top: 1rem;">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    <script src="{{ asset('js/cart_script.js') }}"></script>
</body>
</html>