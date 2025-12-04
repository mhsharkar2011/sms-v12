@extends('layouts.app')

@section('title', 'Departments')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Departments Management</h1>
            <div>
                <a href="{{ route('departments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Department
                </a>
                <a href="{{ route('departments.statistics') }}" class="btn btn-info">
                    <i class="fas fa-chart-bar"></i> Statistics
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Departments</h5>
                        <h2 class="mb-0">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Active</h5>
                        <h2 class="mb-0">{{ $stats['active'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Inactive</h5>
                        <h2 class="mb-0">{{ $stats['inactive'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('departments.index') }}" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by name, code, or description..." value="{{ $search }}">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Departments Table -->
        <div class="card">
            <div class="card-body">
                @if ($departments->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <h4>No departments found</h4>
                        <p class="text-muted">Get started by creating your first department.</p>
                        <a href="{{ route('departments.create') }}" class="btn btn-primary">Create Department</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $department->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $department->code }}</span>
                                        </td>
                                        <td>
                                            {{ Str::limit($department->description, 50) }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $department->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $department->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $department->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('departments.show', $department) }}"
                                                    class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('departments.edit', $department) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('departments.toggle-status', $department) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $department->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                        title="{{ $department->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i
                                                            class="fas {{ $department->is_active ? 'fa-times' : 'fa-check' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('departments.destroy', $department) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this department?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }}
                            of {{ $departments->total() }} entries
                        </div>
                        <div>
                            {{ $departments->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
