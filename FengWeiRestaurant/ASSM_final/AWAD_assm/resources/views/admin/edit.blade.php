<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit - {{ $product->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/adminForm.css') }}">
</head>
<body>

    <x-header data="Edit Dish" />

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>✏ Edit Dish — {{ $product->name }}</h2>
            </div>
            <div class="card-body">

                @if($errors->any())
                    <div class="error-box">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.update', $product->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="field-group">
                        <label>Dish Name *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Category *</label>
                        <input type="text" name="category" value="{{ old('category', $product->category) }}"
                               placeholder="e.g. tofu, pork, chicken..." required>
                        @error('category') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Price (RM) *</label>
                        <input type="number" name="price" step="0.01" min="0"
                               value="{{ old('price', $product->price) }}" required>
                        @error('price') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Description</label>
                        <textarea name="description">{{ old('description', $product->description) }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Image Path (relative to public/images/)</label>
                        <input type="text" name="image_url"
                               value="{{ old('image_url', $product->image_url) }}"
                               placeholder="e.g. tofu/ClaypotTofu.jpg">
                        @error('image_url') <span class="error">{{ $message }}</span> @enderror
                        @if($product->image_url)
                            <img src="{{ asset($product->image_url) }}"
                                 class="preview-img"
                                 onerror="this.style.display='none'">
                        @endif
                    </div>

                    <div class="btn-row">
                        <button type="submit" class="btn btn-brick">Save Changes</button>
                        <a href="{{ route('menu.index') }}" class="btn btn-gray">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>