@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page-title', 'Create New Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Information</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.inventory.store') }}" method="POST">
            @csrf
            
            @include('admin.inventory.form')
            
            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    💾 Create Product
                </button>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection