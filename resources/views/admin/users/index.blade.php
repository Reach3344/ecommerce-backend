@extends('layouts.admin')

@section('page-title', 'Users')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Users</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4">User</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Joined</th>
                    <th class="p-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($user->profile_image_url)
                                    <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">{{ $user->is_admin ? 'Admin' : 'Customer' }}</td>
                        <td class="p-4">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-bold text-white transition hover:bg-emerald-700">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
