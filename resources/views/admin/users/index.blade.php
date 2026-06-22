@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Users</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b">
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">{{ $user->is_admin ? 'Admin' : 'Customer' }}</td>
                        <td class="p-4">{{ $user->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
