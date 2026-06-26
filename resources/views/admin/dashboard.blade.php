@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-950">Dashboard</h1>
            <p class="mt-2 text-sm text-slate-500">Welcome back, {{ auth()->user()->name }}. Here is your store snapshot.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">
            Add Product
        </a>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Categories</p>
            <div class="mt-4 flex items-end justify-between">
                <p class="text-4xl font-bold text-slate-950">{{ $categoryCount }}</p>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">Catalog</span>
            </div>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Products</p>
            <div class="mt-4 flex items-end justify-between">
                <p class="text-4xl font-bold text-slate-950">{{ $productCount }}</p>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Inventory</span>
            </div>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Orders</p>
            <div class="mt-4 flex items-end justify-between">
                <p class="text-4xl font-bold text-slate-950">{{ $orderCount }}</p>
                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Sales</span>
            </div>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Customers</p>
            <div class="mt-4 flex items-end justify-between">
                <p class="text-4xl font-bold text-slate-950">{{ $userCount }}</p>
                <span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-700">Accounts</span>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div>
                <h3 class="font-bold text-slate-950">Latest Orders</h3>
                <p class="mt-1 text-sm text-slate-500">Recent customer purchases and approval status.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[680px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Order</th>
                        <th class="px-5 py-3">Customer</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($latestOrders as $order)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-emerald-700 hover:text-emerald-800">#{{ $order->id }}</a>
                            </td>
                            <td class="px-5 py-4 font-medium text-slate-800">{{ $order->user->name }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $order->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
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
