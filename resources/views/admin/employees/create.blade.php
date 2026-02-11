@extends('layouts.admin')

@section('title', 'Add New Employee')
@section('page-title', 'Create New Employee')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Employee Information</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            
            @include('admin.employees.form')
            
            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    💾 Create Employee
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
