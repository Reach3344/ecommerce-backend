@extends('layouts.admin')

@section('page-title', 'User Details')

@section('content')
    <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Back to users</a>
            <h1 class="mt-2 text-3xl font-bold text-slate-950">{{ $user->name }}</h1>
            <p class="mt-2 text-sm text-slate-500">{{ $user->email }}</p>
        </div>
        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $user->is_admin ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
            {{ $user->is_admin ? 'Admin' : 'Customer' }}
        </span>
    </div>

    <div class="mb-8 grid gap-4 lg:grid-cols-[320px_1fr]">
        <div class="rounded-lg border border-slate-200 bg-white p-6 text-center shadow-sm">
            @if($user->profile_image_url)
                <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="mx-auto h-32 w-32 rounded-full border border-slate-200 object-cover">
            @else
                <div class="mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-emerald-100 text-5xl font-bold text-emerald-700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <h2 class="mt-5 text-xl font-bold text-slate-950">{{ $user->name }}</h2>
            <p class="mt-1 text-sm text-slate-500">Joined {{ $user->created_at->format('M d, Y') }}</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Orders</p>
                <p class="mt-4 text-4xl font-bold text-slate-950">{{ $user->orders->count() }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Cart Items</p>
                <p class="mt-4 text-4xl font-bold text-slate-950">{{ $user->cartItems->count() }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Wishlist</p>
                <p class="mt-4 text-4xl font-bold text-slate-950">{{ $user->wishlistItems->count() }}</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h3 class="font-bold text-slate-950">Recent Orders</h3>
            <p class="mt-1 text-sm text-slate-500">Latest purchases from this user.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Order</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Items</th>
                        <th class="px-5 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($user->orders->take(8) as $order)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-emerald-700 hover:text-emerald-800">#{{ $order->id }}</a>
                                <p class="mt-1 text-xs text-slate-500">{{ $order->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $order->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-700">{{ $order->items->sum('quantity') }}</td>
                            <td class="px-5 py-4 text-right font-bold text-slate-950">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-5 py-8 text-center text-slate-500" colspan="4">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
