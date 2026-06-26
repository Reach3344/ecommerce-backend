<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="flex min-h-screen">
        <aside class="fixed inset-y-0 left-0 z-20 hidden w-72 border-r border-slate-800 bg-slate-950 px-5 py-6 text-white lg:block">
            <div class="mb-8">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-300">Commerce</div>
                <h1 class="mt-2 text-2xl font-bold">E-Shop Admin</h1>
                <p class="mt-2 text-sm text-slate-400">Catalog, orders, and customers.</p>
            </div>

            <nav class="space-y-1">
                @php
                    $links = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard'],
                        ['label' => 'Categories', 'route' => 'admin.categories.index', 'match' => 'admin.categories.*'],
                        ['label' => 'Products', 'route' => 'admin.products.index', 'match' => 'admin.products.*'],
                        ['label' => 'Orders', 'route' => 'admin.orders.index', 'match' => 'admin.orders.*'],
                        ['label' => 'Users', 'route' => 'admin.users.index', 'match' => 'admin.users.*'],
                    ];
                @endphp

                @foreach($links as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="flex items-center justify-between rounded-lg px-4 py-3 text-sm font-medium transition {{ request()->routeIs($link['match']) ? 'bg-emerald-500 text-slate-950 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                    >
                        <span>{{ $link['label'] }}</span>
                        @if(request()->routeIs($link['match']))
                            <span class="h-2 w-2 rounded-full bg-slate-950"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <form action="{{ route('logout') }}" method="POST" class="absolute bottom-6 left-5 right-5 border-t border-slate-800 pt-5" onsubmit="return confirm('Are you sure you want to logout?')">
                @csrf
                <button type="submit" class="w-full rounded-lg px-4 py-3 text-left text-sm font-medium text-rose-300 transition hover:bg-rose-500 hover:text-white">
                    Logout
                </button>
            </form>
        </aside>

        <main class="min-w-0 flex-1 lg:pl-72">
            <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 px-5 py-4 backdrop-blur lg:px-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Admin workspace</p>
                        <h2 class="mt-1 text-xl font-bold text-slate-950">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-5 lg:p-8">
                @if(session('success'))
                    <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
