@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-bold mb-6">Create New Product</h2>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-lg">
    @csrf
    <div>
        <label class="block font-medium">Category</label>
        <select name="category_id" class="w-full border p-2 rounded" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block font-medium">Product Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block font-medium">Description</label>
        <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
        @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block font-medium">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full border p-2 rounded" required>
        @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block font-medium">Stock</label>
        <input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" class="w-full border p-2 rounded" required>
        @error('stock') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block font-medium">Product Image</label>
        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full border p-2 rounded">
        <p class="text-sm text-gray-500 mt-1">Allowed: JPG, PNG, WEBP. Max size: 2MB.</p>
        @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save Product</button>
</form>
@endsection
