@extends('layouts.manager')

@section('title', 'Update Order #' . $order->id)
@section('page-title', 'Update Order')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Order #{{ $order->id }} — {{ $order->user->name ?? 'N/A' }}</h3>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            ← Back to Orders
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Order Items</label>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Tokens Required</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->products as $product)
                                <tr>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-blue">
                                            {{ $product->pivot->tokens_required }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-purple">
                                            x{{ $product->pivot->quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <select
                                            name="statuses[{{ $product->id }}]"
                                            class="form-control"
                                            style="width: 160px;"
                                        >
                                            <option value="pending"  {{ $product->pivot->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $product->pivot->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $product->pivot->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: 700; padding: 16px 20px;">
                                    Order Total:
                                </td>
                                <td style="padding: 16px 20px;">
                                    <strong style="font-size: 16px;">${{ number_format($order->total_price, 2) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection