@extends('layouts.admin')

@section('title', 'Inventory Management')
@section('page-title', 'Inventory Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Products</h3>
        <a href="{{ route('inventory.create') }}" class="btn btn-primary">
            + Add New Product
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-purple">
                                    {{ $product->categorie->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-blue">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ number_format($product->tokens_required) }}</strong>
                            </td>
                            <td>
                                @if($product->premium)
                                    <span class="badge" style="background: #fef3c7; color: #92400e;">
                                        ⭐ Premium
                                    </span>
                                @else
                                    <span class="badge" style="background: #f3f4f6; color: #374151;">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('inventory.edit', $product->id) }}" class="action-btn edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('inventory.destroy', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📦</div>
                                    <p>No products found. Start by adding a new product.</p>
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