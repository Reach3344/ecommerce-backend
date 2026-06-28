<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-stone-50 text-zinc-950">
    <main class="min-h-screen px-4 py-8 sm:px-6 lg:px-8">
        <section class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-6xl flex-col">
            <header class="flex items-center justify-between border-b border-zinc-200 pb-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-md bg-teal-700 text-sm font-black text-white">
                        ES
                    </div>
                    <div>
                        <p class="text-sm font-bold leading-5">E-Shop Admin</p>
                        <p class="text-xs text-zinc-500">Operations back office</p>
                    </div>
                </div>
                <span class="hidden rounded-full border border-zinc-200 bg-white px-3 py-1 text-xs font-medium text-zinc-600 sm:inline-flex">
                    Staff access only
                </span>
            </header>

            <div class="grid flex-1 items-center gap-8 py-10 lg:grid-cols-[minmax(360px,420px)_1fr]">
                <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="mb-8">
                        <p class="text-sm font-semibold text-teal-700">Secure sign in</p>
                        <h1 class="mt-2 text-2xl font-bold text-zinc-950">Welcome back</h1>
                        <p class="mt-2 text-sm text-zinc-500">Use your admin account to continue.</p>
                    </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-zinc-800">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-md border border-zinc-300 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-teal-600 focus:ring-4 focus:ring-teal-100"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-zinc-800">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full rounded-md border border-zinc-300 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-teal-600 focus:ring-4 focus:ring-teal-100"
                        >
                    </div>

                    <label class="flex items-center gap-2 text-sm text-zinc-600">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-zinc-300 text-teal-700">
                        Remember me
                    </label>

                    <button type="submit" class="w-full rounded-md bg-teal-700 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-teal-800">
                        Login
                    </button>
                </form>

                    <p class="mt-8 border-t border-zinc-200 pt-5 text-xs leading-5 text-zinc-500">
                        Access is limited to staff accounts with admin permissions.
                    </p>
                </div>

                <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-zinc-950">Today at a glance</p>
                            <p class="mt-1 text-xs text-zinc-500">A quick read before you open the dashboard.</p>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Live</span>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-md border border-zinc-200 bg-stone-50 p-4">
                            <p class="text-2xl font-bold text-zinc-950">18</p>
                            <p class="mt-1 text-xs font-medium text-zinc-500">Orders waiting</p>
                        </div>
                        <div class="rounded-md border border-zinc-200 bg-stone-50 p-4">
                            <p class="text-2xl font-bold text-zinc-950">6</p>
                            <p class="mt-1 text-xs font-medium text-zinc-500">Low stock SKUs</p>
                        </div>
                        <div class="rounded-md border border-zinc-200 bg-stone-50 p-4">
                            <p class="text-2xl font-bold text-zinc-950">4</p>
                            <p class="mt-1 text-xs font-medium text-zinc-500">Customer notes</p>
                        </div>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-md border border-zinc-200">
                        <div class="grid grid-cols-[1fr_auto] gap-4 border-b border-zinc-200 bg-zinc-50 px-4 py-3 text-xs font-semibold uppercase text-zinc-500">
                            <span>Queue</span>
                            <span>Status</span>
                        </div>
                        <div class="divide-y divide-zinc-200 text-sm">
                            <div class="grid grid-cols-[1fr_auto] gap-4 px-4 py-3">
                                <span class="font-medium text-zinc-800">Approve paid orders</span>
                                <span class="text-amber-700">Pending</span>
                            </div>
                            <div class="grid grid-cols-[1fr_auto] gap-4 px-4 py-3">
                                <span class="font-medium text-zinc-800">Restock best sellers</span>
                                <span class="text-teal-700">Ready</span>
                            </div>
                            <div class="grid grid-cols-[1fr_auto] gap-4 px-4 py-3">
                                <span class="font-medium text-zinc-800">Review new accounts</span>
                                <span class="text-zinc-500">Open</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
