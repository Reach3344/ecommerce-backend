<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-900">
    <main class="grid min-h-screen lg:grid-cols-[1fr_520px]">
        <section class="hidden bg-slate-950 px-12 py-10 text-white lg:flex lg:flex-col lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-300">E-Shop Admin</p>
                <h1 class="mt-6 max-w-xl text-5xl font-bold leading-tight">Run your store from one focused workspace.</h1>
                <p class="mt-5 max-w-lg text-base leading-7 text-slate-300">Manage products, inventory, orders, and customers with a clean back office built for daily ecommerce work.</p>
            </div>

            <div class="grid max-w-2xl grid-cols-3 gap-4">
                <div class="rounded-lg border border-slate-800 bg-slate-900 p-4">
                    <p class="text-2xl font-bold text-emerald-300">24/7</p>
                    <p class="mt-1 text-sm text-slate-400">Store operations</p>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900 p-4">
                    <p class="text-2xl font-bold text-amber-300">Fast</p>
                    <p class="mt-1 text-sm text-slate-400">Order approval</p>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900 p-4">
                    <p class="text-2xl font-bold text-sky-300">Live</p>
                    <p class="mt-1 text-sm text-slate-400">Inventory control</p>
                </div>
            </div>
        </section>

        <section class="flex items-center justify-center bg-slate-100 p-6">
            <div class="w-full max-w-md rounded-lg border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/10">
                <div class="mb-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">Secure admin</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-950">Welcome back</h2>
                    <p class="mt-2 text-sm text-slate-500">Sign in to continue managing your store.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                        >
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600">
                        Remember me
                    </label>

                    <button type="submit" class="w-full rounded-lg bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">
                        Login
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
