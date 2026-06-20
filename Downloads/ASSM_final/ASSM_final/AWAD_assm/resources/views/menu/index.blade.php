<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu - Feng Wei</title>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <script src="{{ asset('js/menu.js') }}" defer></script>
</head>
<body>
    <x-header data="Menu" />
    <x-navigation />

    <aside class="sidebar">
        <h3>Categories</h3>
        @foreach($categories as $cat => $products)
            <a href="#{{ Str::slug($cat) }}">{{ $cat }}</a>
        @endforeach
    </aside>

    <div class="main-content">
        <div class="search-box">
            <input type="text" id="search" placeholder="Search..." onkeyup="searchMenu()">

            {{-- Admin Edit Mode toggle --}}
            @if(Auth::check() && Auth::user()->role === 'admin')
                <button class="admin-toggle-btn" id="editModeBtn" onclick="toggleEditMode()">
                    ✏ Edit Mode
                </button>
            @endif

            <a href="{{ route('cart.index') }}" class="cart-icon">
                <img src="{{ asset('icon/cart_.png') }}" alt="cart">
                <span class="cart-count">{{ $cartTotalItems }}</span>
            </a>
        </div>

        @if(session('success'))
            <div style="background:#d4edda;color:#155724;border:1px solid #c3e6cb;border-radius:6px;padding:0.6rem 1rem;margin-bottom:1rem;font-size:0.875rem;">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($categories as $cat => $products)
            <h1 id="{{ Str::slug($cat) }}">{{ $cat }}</h1>
            <div class="menu">
                @foreach ($products as $dish)
                    <div class="item">
                        <a href="{{ route('menu.show', $dish->id) }}"
                           class="dish-img-link"
                           data-edit-url="{{ Auth::check() && Auth::user()->role === 'admin' ? route('admin.edit', $dish->id) : '' }}">
                            <img src="{{ asset($dish->image_url) }}" alt="{{ $dish->name }}"
                                 onerror="this.src='{{ asset('icon/food.png') }}'">
                        </a>
                        <h3>{{ $dish->name }}</h3>
                        <p>RM {{ number_format($dish->price, 2) }}</p>

                        {{-- Add to Cart (shown by default) --}}
                        <form action="{{ route('cart.add', $dish->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                        </form>

                        {{-- Edit button (shown in edit mode, admin only) --}}
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('admin.edit', $dish->id) }}" class="edit-dish-btn">✏ Edit</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <script>
        function toggleEditMode() {
            const body = document.body;
            const btn  = document.getElementById('editModeBtn');
            body.classList.toggle('edit-mode');
            const isEditMode = body.classList.contains('edit-mode');

            if (isEditMode) {
                btn.textContent = '✕ Exit Edit Mode';
                btn.classList.add('active');
            } else {
                btn.textContent = '✏ Edit Mode';
                btn.classList.remove('active');
            }

            document.querySelectorAll('.dish-img-link').forEach(link => {
                const editUrl = link.dataset.editUrl;
                if (!editUrl) return;

                if (isEditMode) {
                    link.dataset.originalUrl = link.href;
                    link.href = editUrl;
                } else {
                    link.href = link.dataset.originalUrl || link.href;
                }
            });
        }
    </script>
</body>
</html>