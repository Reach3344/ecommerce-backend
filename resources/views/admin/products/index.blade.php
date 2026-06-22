@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Products</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Product</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4">Image</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Stock</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b">
                        <td class="p-4">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-16 w-16 rounded object-cover border">
                            @else
                                <div class="h-16 w-16 rounded border bg-gray-100 flex items-center justify-center text-xs text-gray-500">No image</div>
                            @endif
                        </td>
                        <td class="p-4">{{ $product->name }}</td>
                        <td class="p-4">{{ $product->category->name }}</td>
                        <td class="p-4">${{ number_format($product->price, 2) }}</td>
                        <td class="p-4">{{ $product->stock }}</td>
                        <td class="p-4 flex gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-600">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-4 text-gray-500" colspan="6">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
