<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Admin Login</h1>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 text-red-700 p-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" value="1" class="rounded border-gray-300">
                Remember me
            </label>

            <button type="submit" class="w-full bg-blue-600 text-white font-medium rounded p-3 hover:bg-blue-700">
                Login
            </button>
        </form>
    </div>
</body>
</html>
