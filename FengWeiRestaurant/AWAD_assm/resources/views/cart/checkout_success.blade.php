<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Successful - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>
    <x-header data="Checkout" />
    <x-navigation />

    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1>Order Successful!</h1>
        <p>Thank you for your purchase. Your order has been placed successfully.</p>
        <a href="{{ route('home') }}" class="continue-shopping" style="margin-top: 2rem;">
            Return to Homepage
        </a>
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
            <span>&copy; 2024 Feng Wei. All rights reserved.</span>
        </div>
    </div>
</body>
</html>