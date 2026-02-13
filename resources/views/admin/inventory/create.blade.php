@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page-title', 'Create New Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Information</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @include('admin.inventory.form')
            
            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    💾 Create Product
                </button>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection