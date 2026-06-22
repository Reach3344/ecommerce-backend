@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Edit Product</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-lg">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Category</label>
            <select name="category_id" class="w-full border p-2 rounded" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Product Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border p-2 rounded" required>
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border p-2 rounded" required>
            @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Stock</label>
            <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border p-2 rounded" required>
            @error('stock') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Product Image</label>
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-3 h-28 w-28 rounded object-cover border">
            @endif
            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full border p-2 rounded">
            <p class="text-sm text-gray-500 mt-1">Allowed: JPG, PNG, WEBP. Max size: 2MB.</p>
            @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 px-4 py-2 rounded">Cancel</a>
        </div>
    </form>
@endsection
