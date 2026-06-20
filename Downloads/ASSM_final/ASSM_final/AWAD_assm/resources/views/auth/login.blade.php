<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login & Sign Up - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/stylesLogin.css') }}">
</head>
<body>
    <div class="backHome">
        <button id="backHomeBtn" onclick="window.location.href='{{ route('home') }}'">
            <img src="{{ asset('icon/left-arrow.png') }}" alt="Home">
            <span>BACK TO HOME</span>
        </button>
    </div>

    <div class="container {{ $errors->hasAny(['username', 'phoneNumber']) || old('username') ? 'right-panel-active' : '' }}" id="container">

        {{-- SIGN UP — hidden by default (opacity:0, z-index:1 via .Signupbox in CSS) --}}
        <div class="form-container Signupbox">
            <form action="{{ route('signup.submit') }}" method="POST" id="SignUpForm" style="padding-top: 40px;">
                @csrf
                <h1>Create Account</h1>
                <span>Use your email for registration</span>

                <input type="text" placeholder="Username" name="username" value="{{ old('username') }}">
                <span class="error" id="usernameError">
                    @error('username') {{ $message }} @enderror
                </span>

                <div style="display:flex; width:100%; gap:8px; margin: 8px 0;">
                    <input type="text" placeholder="+60" name="countryCode"
                           value="{{ old('countryCode', '+60') }}" style="width:30%; margin:0;">
                    <input type="text" placeholder="Phone Number" name="phoneNumber"
                           value="{{ old('phoneNumber') }}" style="width:70%; margin:0;">
                </div>
                <span class="error" id="phoneError">
                    @error('phoneNumber') {{ $message }} @enderror
                </span>

                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                <span class="error" id="signupEmailError">
                    @error('email') {{ $message }} @enderror
                </span>

                <input type="password" placeholder="Password" name="password">
                <span class="error" id="signUpPasswordError">
                    @error('password') {{ $message }} @enderror
                </span>

                <input type="password" placeholder="Confirm Password" name="password_confirmation">
                <span class="error" id="confirmPasswordError"></span>

                <button type="button" id="signupButton">Sign Up</button>
            </form>
        </div>

        {{-- LOGIN — visible by default (z-index:2 via .Loginbox in CSS) --}}
        <div class="form-container Loginbox">
            <form action="{{ route('login.submit') }}" method="POST" id="LoginForm" style="padding-top: 60px;">
                @csrf
                <h1>Sign in</h1>
                <span>Use your account</span>

                @error('login')
                    <div style="color:red; font-size:12px; margin-bottom:8px;">{{ $message }}</div>
                @enderror

                @if(session('success'))
                    <div class="success-message">{{ session('success') }}</div>
                @endif

                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                <span class="error" id="loginEmailError" style="display:block; min-height:14px;"></span>

                <input type="password" placeholder="Password" name="password">
                <span class="error" id="loginPasswordError" style="display:block; min-height:14px;"></span>

                <a href="{{ route('password.request') }}">Forgot your password?</a>
                <button type="button" id="loginButton">Login</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h2>Have an account?</h2>
                    <img src="{{ asset('icon/food/2.png') }}" alt="food" class="foodImg">
                    <p>Login to your account and start ordering your favourite meals!</p>
                    <button class="ghost" id="switchLogin">Login</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h2>New here?</h2>
                    <img src="{{ asset('icon/food/1.png') }}" alt="food" class="foodImg">
                    <p>Create an account and explore our delicious menu!</p>
                    <button class="ghost" id="switchSignup">Sign Up</button>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>