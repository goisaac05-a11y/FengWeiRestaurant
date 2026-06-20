<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <style>body{margin: 0;}</style>
</head>
<body>
    <x-header data="Contact" />
    <x-navigation />

    <div class="contact-page">
        <div class="page-header">
            <h1>Contact Us</h1>
            <p>We're here to help with your questions and concerns</p>
        </div>  
        
        @include('contact.form')
    </div>

    <div class="footer">
        <div class="info">
            <div class ="pannel">
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