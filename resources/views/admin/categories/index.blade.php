@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
        Add Category
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-4">Name</th>
                <th class="p-4">Products</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($categories as $category)
            <tr class="border-b">
                <td class="p-4">{{ $category->name }}</td>
                <td class="p-4">{{ $category->products_count }}</td>

                <td class="p-4 flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-yellow-600">
                        Edit
                    </a>

                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                          onsubmit="return confirm('Delete category?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="text-red-600">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
