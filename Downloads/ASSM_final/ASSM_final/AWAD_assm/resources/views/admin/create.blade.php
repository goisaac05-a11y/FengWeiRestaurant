<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Add New Dish</title>
    <link rel="stylesheet" href="{{ asset('css/adminForm.css') }}">
</head>
<body>

    <x-header data="Add New Dish" />

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>🍽 Add New Dish</h2>
            </div>
            <div class="card-body">

                @if($errors->any())
                    <div class="error-box">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.store') }}">
                    @csrf

                    <div class="field-group">
                        <label>Dish Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="e.g. Claypot Tofu" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Category *</label>
                        <input type="text" name="category" value="{{ old('category') }}"
                               placeholder="e.g. tofu, pork, chicken, vegetable..." required>
                        <span class="hint">Use lowercase — this determines which section the dish appears in.</span>
                        @error('category') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Price (RM) *</label>
                        <input type="number" name="price" step="0.01" min="0"
                               value="{{ old('price') }}" placeholder="0.00" required>
                        @error('price') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Description</label>
                        <textarea name="description" placeholder="Brief description of the dish...">{{ old('description') }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field-group">
                        <label>Image Path (relative to public/images/)</label>
                        <input type="text" name="image_url" value="{{ old('image_url') }}"
                               placeholder="e.g. tofu/ClaypotTofu.jpg">
                        <span class="hint">Make sure the image file exists in public/images/ first.</span>
                        @error('image_url') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="btn-row">
                        <button type="submit" class="btn btn-mint">Add Dish</button>
                        <a href="{{ route('admin.index') }}" class="btn btn-gray">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>