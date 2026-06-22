@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
        <p class="mt-1 text-gray-600">Welcome back, {{ auth()->user()->name }}.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Categories</p>
            <p class="text-3xl font-bold">{{ $categoryCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Products</p>
            <p class="text-3xl font-bold">{{ $productCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Orders</p>
            <p class="text-3xl font-bold">{{ $orderCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Customers</p>
            <p class="text-3xl font-bold">{{ $userCount }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 border-b">
            <h3 class="font-semibold text-gray-900">Latest Orders</h3>
        </div>
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4">Order</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestOrders as $order)
                    <tr class="border-t">
                        <td class="p-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600">#{{ $order->id }}</a>
                        </td>
                        <td class="p-4">{{ $order->user->name }}</td>
                        <td class="p-4">{{ ucfirst($order->status) }}</td>
                        <td class="p-4">${{ number_format($order->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-4 text-gray-500" colspan="4">No orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
