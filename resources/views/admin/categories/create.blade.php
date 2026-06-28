@extends('layouts.admin')

@section('page-title', 'Create Category')

@section('content')
    <div class="mb-7">
        <h1 class="text-3xl font-bold text-slate-950">Create Category</h1>
        <p class="mt-2 text-sm text-slate-500">Add a new group for products in your storefront.</p>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="max-w-2xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="name" class="mb-2 block text-sm font-bold text-slate-700">Name</label>
            <input id="name" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" required>
            @error('name') <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p> @enderror
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700">Save Category</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-100">Cancel</a>
        </div>
    </form>
@endsection
