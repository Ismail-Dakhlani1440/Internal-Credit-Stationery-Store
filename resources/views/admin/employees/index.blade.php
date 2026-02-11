@extends('layouts.admin')

@section('title', 'Manage Employees')
@section('page-title', 'Employee Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Employees</h3>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            + Add New Employee
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>
                                <strong>{{ $employee->name }}</strong>
                            </td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                <span class="badge badge-blue">
                                    {{ $employee->role->title ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-purple">
                                    {{ $employee->department->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('employees.edit', $employee) }}" class="action-btn edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this employee?')">
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
                                    <div class="empty-state-icon">👤</div>
                                    <p>No employees found. Start by adding a new employee.</p>
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