<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
   <body class="min-h-screen bg-gradient-to-br from-slate-100 to-gray-200 flex items-center justify-center">

<div class="w-full max-w-md rounded-2xl bg-white shadow-2xl p-8">

    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <div class="h-16 w-16 rounded-full bg-teal-600 flex items-center justify-center shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 12l5 5L20 7"/>
            </svg>
        </div>
    </div>

    <div class="text-center mb-8">

        <h1 class="text-3xl font-bold text-gray-900">
            Welcome Back
        </h1>

        <p class="mt-2 text-gray-500">
            Sign in to your admin account
        </p>

    </div>

    @if($errors->any())
    <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
        @csrf

        <div>
            <label class="text-sm font-semibold text-gray-700">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="admin@example.com"
                class="mt-2 w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition">
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-700">
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="••••••••"
                class="mt-2 w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition">
        </div>

        <div class="flex items-center justify-between">

            <label class="flex items-center gap-2 text-sm text-gray-600">

                <input type="checkbox" name="remember"
                class="rounded border-gray-300 text-teal-600">

                Remember me

            </label>

            <a href="#" class="text-sm text-teal-600 hover:underline">
                Forgot?
            </a>

        </div>

        <button
            class="w-full rounded-xl bg-teal-600 py-3 text-lg font-semibold text-white shadow-lg transition duration-300 hover:bg-teal-700 hover:-translate-y-0.5">
            Login
        </button>

    </form>

    <div class="mt-8 text-center text-xs text-gray-400">
        © 2026 Ecommerce Admin Panel
    </div>

</div>

</body>
</html>
