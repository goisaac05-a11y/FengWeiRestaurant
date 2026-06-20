<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }} - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/details.css') }}">
</head>
<body>
    <div class="container">
        <a href="{{ route('menu.index') }}" class="back-button">&larr; Back to Menu</a>
        <img src="{{ asset($product->image_url) }}" class="product-image"
             onerror="this.src='{{ asset('icon/food.png') }}'">
        <h1>{{ $product->name }}</h1>
        <p class="price">RM {{ number_format($product->price, 2) }}</p>

        @if($product->description)
            <p style="text-align:center; color:#666; font-size:1rem; margin: 0 0 20px; line-height:1.7;">
                {{ $product->description }}
            </p>
        @endif

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit">Add to Cart</button>
        </form>
    </div>
</body>
</html>