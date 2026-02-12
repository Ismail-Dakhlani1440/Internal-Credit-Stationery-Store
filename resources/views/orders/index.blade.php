@extends('layouts.manager')

@section('title', 'Manage Orders')
@section('page-title', 'Order Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Orders</h3>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            + Add New Order
        </a>
    </div>

    <div class="card-body">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>#{{ $order->id }}</strong>
                            </td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>
                                <strong>${{ number_format($order->total_price, 2) }}</strong>
                            </td>
                            <td>
                                @php
                                    $statusClass = match($order->status) {
                                        'approved' => 'badge-green',
                                        'pending'  => 'badge-yellow',
                                        'rejected' => 'badge-red',
                                        'partial'  => 'badge-purple',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('orders.edit', $order) }}" class="action-btn edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this order?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">🛒</div>
                                    <p>No orders found. Start by adding a new order.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection