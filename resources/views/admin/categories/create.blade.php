@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Create Category</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-lg">
        @csrf

        <div>
            <label for="name" class="block font-medium mb-1">Name</label>
            <input id="name" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 px-4 py-2 rounded">Cancel</a>
        </div>
    </form>
@endsection
