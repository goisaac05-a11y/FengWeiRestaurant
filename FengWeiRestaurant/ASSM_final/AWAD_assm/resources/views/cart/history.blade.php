<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>
    <x-header data="Order History" />
    <x-navigation />
    
    <div class="back-to-home">
        <a href="{{ route('cart.index') }}" class="back-button">← Back to Cart</a>
    </div>

    <div class="history-container" style="max-width: 800px; margin: 2rem auto; padding: 0 1rem;">

        <div class="page-header">
            <h1>Order History</h1>
            <p>View your previous orders</p>
        </div>

        @if($orders->isEmpty())
            <div class="empty-history">
                <img src="{{ asset('icon/food.png') }}" alt="No Orders" style="width: 64px; opacity: 0.5; margin-bottom: 1rem;">
                <h2>No previous orders found</h2>
                <p>When you place an order, it will appear here.</p>
                <a href="{{ route('menu.index') }}" class="continue-shopping" style="display: inline-block; margin-top: 1rem;">
                    Start Ordering
                </a>
            </div>
        @else
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-id">Order #{{ str_pad($order->id ?? $loop->iteration, 5, '0', STR_PAD_LEFT) }}</span>
                        <span class="status-badge">Completed</span>
                        <span class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->format('F j, Y, g:i a') }}</span>
                    </div>

                    <div class="order-items">
                        {{-- Use Eloquent relationship loaded via ->with('items') --}}
                        @foreach($order->items as $item)
                            @php
                                $itemName = is_array($item) ? ($item['name'] ?? '') : ($item->name ?? '');
                                $itemQuantity = is_array($item) ? ($item['quantity'] ?? 0) : ($item->quantity ?? 0);
                                $itemPrice = is_array($item) ? ($item['price'] ?? 0) : ($item->price ?? 0);
                            @endphp
                            <div style="display:flex; justify-content:space-between; padding: 0.25rem 0;">
                                <span>{{ $itemName }} × {{ $itemQuantity }}</span>
                                <span>RM{{ number_format($itemPrice * $itemQuantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-total">
                        Total: RM{{ number_format($order->total, 2) }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="footer">
        <div class="info">
            <div class="pannel">
                <h4 class="FooterSubtitle">Feng Wei</h4>
                <span class="caption">Experience authentic Asian cuisine in the heart of the city. <br>Our master chefs bring traditional flavors with a modern twist.</span>
                <div class="socialMedia">
                    <button><img src="{{ asset('icon/facebook.png') }}" alt="facebook"></button>
                    <button><img src="{{ asset('icon/instagram.png') }}" alt="instagram"></button>
                    <button><img src="{{ asset('icon/tik-tok.png') }}" alt="tiktok"></button>
                    <button><img src="{{ asset('icon/social.png') }}" alt="social"></button>
                </div>
            </div>
            <div class="pannel">
                <h4 class="FooterSubtitle">Contact & Hours</h4>
                <ul>
                    <li>123 China Street, Food District</li>
                    <li>(+60) 0123456789</li>
                    <li>info@fengwei.com</li> 
                </ul>
            </div>
        </div>
        <div class="copyright">
            <span>&copy 2024 Feng Wei. All rights reserved.</span>
        </div>
    </div>
</body>
</html>