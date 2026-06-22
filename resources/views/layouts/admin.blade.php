<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <aside class="w-64 bg-gray-800 text-white min-h-screen p-4 space-y-6">
        <h1 class="text-xl font-bold tracking-wider">E-Shop Admin</h1>
        <nav class="space-y-2 flex flex-col">
            <a href="{{ route('admin.dashboard') }}" class="p-2 hover:bg-gray-700 rounded">Dashboard</a>
            <a href="{{ route('admin.categories.index') }}" class="p-2 hover:bg-gray-700 rounded">Categories</a>
            <a href="{{ route('admin.products.index') }}" class="p-2 hover:bg-gray-700 rounded">Products</a>
            <a href="{{ route('admin.orders.index') }}" class="p-2 hover:bg-gray-700 rounded">Orders</a>
            <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-gray-700 rounded">Users</a>
            <form action="{{ route('logout') }}" method="POST" class="pt-4 border-t border-gray-700">
                @csrf
                <button type="submit" class="w-full text-left p-2 text-red-400 hover:bg-gray-700 rounded">Logout</button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
