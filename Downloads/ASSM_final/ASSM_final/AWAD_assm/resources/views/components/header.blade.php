@props(['data' => null])
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap');

    :root {
        --fresh-mint: #8BC34A;
        --deep-brick-red: #9B1B1B;
        --warm-walnut: #6B4226;
        --porcelain-white: #F8F8F4;
        --charcoal-black: #1E1E1E;
        --warm-gold: #C5A46D;
    }

    /* Logo Banner */
    .LogoBanner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, var(--deep-brick-red), var(--warm-walnut));
        height: 80px;
        color: var(--warm-gold);
        position: sticky;
        top: 0; 
        padding: 10px 20px; 
        z-index: 1002; 
        box-sizing: border-box; 
    }

    .LogoBanner::after {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 2.5em;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        letter-spacing: 3px;
        text-align: center;
    }

    .LogoBanner p {
        font-size: 3.0em;
        text-align: left;
        font-weight: 600;
        color: #fbc5a1;
        margin: 0;
    }

    .userIconButton {
        display: flex;
        align-items: center;
        border-radius: 20px;
        border: 1px solid #F8F8F4;
        max-width: 250px;
        height: 40px; 
        padding: 2px 8px 2px 10px;
        gap: 5px;
        margin-left: auto;
        cursor: pointer;
        transition: background-color 0.3s ease; 
        font-size: 1.0em;
        font-weight: 600;
        font-family: 'Montserrat', sans-serif;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .guestLogin {
        display: flex;
        text-decoration: none;
        color: #f0f0f0;
        align-items: center;
        border-radius: 20px;
        border: 1px solid #F8F8F4;
        width: auto;
        height: auto; 
        padding: 2px 8px 2px 10px; 
        gap: 5px;
        margin-left: auto; 
        cursor: pointer; 
        transition: background-color 0.3s ease; 
        font-size: 1.0em;
        font-weight: 600;
        font-family: 'Montserrat', sans-serif;
    }

    .userIconButton:hover, .guestLogin:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: linear-gradient(135deg, #ffffff, #f9f9f9);
        min-width: 160px;
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        z-index: 9999;
        overflow: hidden;
        animation: dropdownFade 0.2s ease-in-out;
    }

    .dropdown button {
        width: 100%;
        padding: 12px 16px;
        border: none;
        background: transparent;
        font-size: 14px;
        font-weight: 500;
        text-align: left;
        cursor: pointer;
        color: #333;
        transition: background 0.2s, padding-left 0.2s;
    }

    .dropdown button:hover {
        background: linear-gradient(135deg, #f0f4ff, #e4ecff);
        padding-left: 20px; 
        color: #1a73e8;
    }

    .dropdown .divider {
        height: 1px;
        background: #e0e0e0;
        margin: 4px 0;
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .user-menu:hover .dropdown,
    .user-menu:focus-within .dropdown {
        display: block;
    }

    #logo {
        font-family: "Cormorant Garamond", serif;
        font-size: 1.8em;
        text-decoration: none;
        color: #fcbc4c;
    }

    .dropdown.show {
        display: block;
    }

    .user-menu {
        position: relative;
        margin-left: auto;
        z-index: 10000;
    }
</style>

<div class="LogoBanner">
    <p id="logo">Feng Wei {{ $data ? ' - ' . $data : '' }}</p>
    
    <div style="display: flex; align-items: center; gap: 20px; margin-left: auto;">
        
        @if(request()->routeIs('admin.create') || request()->routeIs('admin.edit'))
            <a href="{{ route('menu.index') }}" style="color: #fbc5a1; text-decoration: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 0.95em; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">← Back to Menu</a>
        @elseif(request()->routeIs('admin.index'))
            <a href="{{ route('home') }}" style="color: #fbc5a1; text-decoration: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 0.95em; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">← Back to Site</a>
        @endif

        <div class="user-menu" style="margin-left: 0;">
            @if(Auth::check() || session()->has('username')) 
                <button class="userIconButton">
                    <span>{{ Auth::check() ? Auth::user()->username : session('username') }}</span>
                    <img src="{{ asset('icon/paw.png') }}" alt="profile">
                </button>

                <div class="dropdown">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="guestLogin">
                    Login / Sign Up <img src="{{ asset('icon/profile.png') }}" alt="profile">
                </a>
            @endif
        </div>
    </div>
</div>