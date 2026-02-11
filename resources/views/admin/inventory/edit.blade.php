@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product: ' . $product->name)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Update Product Information</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('inventory.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            @include('admin.inventory.form')
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    💾 Update Product
                </button>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection