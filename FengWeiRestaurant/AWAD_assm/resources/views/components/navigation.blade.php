<style>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap");

.navigation {
    list-style-type: none;
    margin: 0;
    padding: 0;
    background: #FAF9F6; 
    font-family: "Montserrat", sans-serif;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 1px;
    position: sticky;
    top: 80px; 
    z-index: 1000;
    height: 60px; 
}

.navigation.ul{
    margin:0;
}

.navigation li {
    margin-left: 16px;
    margin-right: 16px;
}

.navigation li:last-child {
    margin-right: 0;
}

.navigation li a {
    display: block;
    color: #1E1E1E;
    text-decoration: none;
    padding: 14px 0 10px 0;
    transition: all 0.3s ease;
    text-transform: uppercase;
    position: relative;
}

.navigation li.active a {
    color: #EE6C4D; 
}

.navigation li a::after {
    content: "";
    display: block;
    height: 2px;
    width: 0;
    background: #8BC34A; 
    transition: width 0.3s ease;
    position: absolute;
    bottom: 4px;
    left: 0;
}

.navigation li a:hover {
    color: #F4D35E;
}

.navigation li a:hover::after,
.navigation li.active a::after {
    width: 100%;
}
</style>

<ul class="navigation">
    <div class="highlight"></div>
    
    <li @class(['active' => request()->routeIs('home')])>
        <a href="{{ route('home') }}">Home</a>
    </li>
    
    <li @class(['active' => request()->routeIs('menu.index')])>
        <a href="{{ route('menu.index') }}">Menu</a>
    </li>
    
    <li @class(['active' => request()->routeIs('cart.index')])>
        <a href="{{ route('cart.index') }}">My Cart</a>
    </li>
    
    <li @class(['active' => request()->routeIs('orders.history')])>
        <a href="{{ route('orders.history') }}">Order History</a>
    </li>

    <li @class(['active' => request()->routeIs('contact.index')])>
        <a href="{{ route('contact.index') }}">Contact Us</a>
    </li>
    
    @can('admin-only')
        <li @class(['active' => request()->routeIs('admin.index')])>
            <a href="{{ route('admin.index') }}">Menu Management</a>
        </li>
    @endcan
    
    @guest
        <li @class(['active' => request()->routeIs('login')])>
            <a href="{{ route('login') }}">Login/Sign Up</a>
        </li>
    @endguest
</ul>