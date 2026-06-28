@extends('layouts.admin')

@section('page-title', 'Profile')

@section('content')
    <div class="mb-7">
        <h1 class="text-3xl font-bold text-slate-950">Profile</h1>
        <p class="mt-2 text-sm text-slate-500">Update your admin account details and profile image.</p>
    </div>

    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex flex-wrap items-center gap-5">
                @if($user->profile_image_url)
                    <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-full border border-slate-200 object-cover">
                @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100 text-3xl font-bold text-emerald-700">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <div class="min-w-0 flex-1">
                    <label for="profile_image" class="mb-2 block text-sm font-semibold text-slate-700">Profile image</label>
                    <input
                        id="profile_image"
                        name="profile_image"
                        type="file"
                        accept="image/png,image/jpeg,image/webp"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200"
                    >
                    <p class="mt-2 text-xs text-slate-500">JPG, PNG, or WebP. Max 2MB.</p>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                    >
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                    >
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">
                    Save Profile
                </button>
            </div>
        </form>
    </div>
@endsection
