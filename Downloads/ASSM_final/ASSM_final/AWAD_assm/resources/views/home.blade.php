<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to Feng Wei</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

    <x-header data="Home" />
    <x-navigation />
            
    <div class="MainBanner">
        <div class="bannerCaption">
            <h2 id="welcome">Welcome to <p id="logo">Feng Wei</p></h2>
            <p>Journey through Asia's finest flavors</p>
            <a href="{{ route('menu.index') }}"><button class="glass-button">Start Order</button></a>
        </div>
    </div>

    <div class="TodaySpecial">
        <h3 class="subtitle">Today's Special</h3>
        <span class="caption">Get excited about today's incredible offering...</span>
        
        <div class="cardSection">
            @foreach($specials as $product)
                <div class="card">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="card-image">
                    <div class="product-details">
                        <h3>{{ $product->name }}</h3>
                        <p class="description">{{ $product->description }}</p>
                        <div class="price-action">
                            <span class="price">RM {{ number_format($product->price, 2) }}</span></br>
                            <a href="{{ route('menu.show', $product->id) }}" class="btn-buy">Buy Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="Chef">
        <div class="chef">
            <h4 class="subtitle">Award-Winning Culinary Team</h4>
            <span class="caption">Our master chefs bring decades of experience from top restaurants across Asia, <br>crafting each dish with precision, passion, and authentic techniques.</span>
        </div>
        <div class="chefImg">
            <img id="image" src="{{ asset('icon/chef-4807317_1920.jpg') }}" alt="Chef">
        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userButton = document.querySelector('.userIconButton');
            const dropdown = document.querySelector('.dropdown');
            
            if (userButton && dropdown) {
                userButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('show');
                });
                
                document.addEventListener('click', function(e) {
                    if (!userButton.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.remove('show');
                    }
                });
                
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        dropdown.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>