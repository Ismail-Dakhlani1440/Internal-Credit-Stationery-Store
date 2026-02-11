@extends('layouts.admin')

@section('title', 'Edit Employee')
@section('page-title', 'Edit Employee: ' . $employee->name)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Update Employee Information</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')
            
            @include('admin.employees.form')
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    💾 Update Employee
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection