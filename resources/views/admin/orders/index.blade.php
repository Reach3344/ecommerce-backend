@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Orders</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4">Order</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Items</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b">
                        <td class="p-4"><a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600">#{{ $order->id }}</a></td>
                        <td class="p-4">{{ $order->user->name }}</td>
                        <td class="p-4">{{ $order->items->count() }}</td>
                        <td class="p-4">{{ ucfirst($order->status) }}</td>
                        <td class="p-4">${{ number_format($order->total, 2) }}</td>
                        <td class="p-4">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="p-4">
                            @if($order->status === 'pending')
                                <form action="{{ route('admin.orders.approve', $order) }}" method="POST" onsubmit="return confirm('Approve this order and deduct stock?')">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Approve
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500">Approved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-4 text-gray-500" colspan="7">No orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
