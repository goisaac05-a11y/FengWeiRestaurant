<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Menu</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <x-header data="Admin" />

    <div class="container">

        <div class="page-header">
            <h2>Menu Management</h2>
            <a href="{{ route('admin.create') }}" class="btn btn-green">+ Add New Dish</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset($product->image_url) }}"
                                     alt="{{ $product->name }}"
                                     class="product-img"
                                     onerror="this.src='{{ asset('icon/food.png') }}'">
                            </td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td><span class="category-badge">{{ $product->category }}</span></td>
                            <td>RM {{ number_format($product->price, 2) }}</td>
                            <td style="max-width:200px; color:#666; font-size:0.82rem;">
                                {{ Str::limit($product->description, 60) }}
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.edit', $product->id) }}" class="btn btn-blue">Edit</a>
                                    <form method="POST" action="{{ route('admin.destroy', $product->id) }}"
                                          onsubmit="return confirm('Delete {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>