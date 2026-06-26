@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Order #{{ $order->id }}</h2>
        <div class="flex items-center gap-3">
            @if($order->status === 'pending')
                <form action="{{ route('admin.orders.approve', $order) }}" method="POST" onsubmit="return confirm('Approve this order and deduct stock?')">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Approve Order
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-200 px-4 py-2 rounded">Back</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-semibold mb-3">Status</h3>
        <p>{{ ucfirst($order->status) }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Customer</h3>
            <p>{{ $order->user->name }}</p>
            <p class="text-gray-600">{{ $order->user->email }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Shipping</h3>
            <p>{{ $order->shipping_name }}</p>
            <p>{{ $order->shipping_email }}</p>
            <p>{{ $order->shipping_phone }}</p>
            <p class="text-gray-600">{{ $order->shipping_address }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4">Product</th>
                    <th class="p-4">Qty</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b">
                        <td class="p-4">{{ $item->product_name }}</td>
                        <td class="p-4">{{ $item->quantity }}</td>
                        <td class="p-4">${{ number_format($item->price, 2) }}</td>
                        <td class="p-4">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="p-4 font-bold text-right" colspan="3">Total</td>
                    <td class="p-4 font-bold">${{ number_format($order->total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
