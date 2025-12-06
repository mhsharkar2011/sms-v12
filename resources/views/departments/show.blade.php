@extends('layouts.app')

@section('title', $department->name)

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2">{{ $department->name }}</h1>
                <p class="text-muted mb-0">{{ $department->code }} •
                    <span class="badge {{ $department->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $department->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Information -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Department Information</h5>
                    </div>
                    <div class="card-body">
                        @if ($department->description)
                            <p class="lead">{{ $department->description }}</p>
                        @else
                            <p class="text-muted">No description available.</p>
                        @endif

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Department Details</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="150">Code:</th>
                                        <td>{{ $department->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge {{ $department->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $department->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ $department->created_at->format('F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated:</th>
                                        <td>{{ $department->updated_at->format('F d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Statistics</h6>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="card bg-primary text-white text-center">
                                            <div class="card-body p-3">
                                                <h6 class="mb-1">Teachers</h6>
                                                <h4 class="mb-0">{{ $department->teachers_count ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="card bg-success text-white text-center">
                                            <div class="card-body p-3">
                                                <h6 class="mb-1">Classes</h6>
                                                <h4 class="mb-0">{{ $department->classes_count ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card bg-info text-white text-center">
                                            <div class="card-body p-3">
                                                <h6 class="mb-1">Subjects</h6>
                                                <h4 class="mb-0">{{ $department->subjects_count ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card bg-warning text-white text-center">
                                            <div class="card-body p-3">
                                                <h6 class="mb-1">Students</h6>
                                                <h4 class="mb-0">{{ $department->students_count ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Sidebar -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Department
                            </a>

                            <form action="{{ route('departments.toggle-status', $department) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary w-100">
                                    <i class="fas {{ $department->is_active ? 'fa-times' : 'fa-check' }}"></i>
                                    {{ $department->is_active ? 'Deactivate' : 'Activate' }} Department
                                </button>
                            </form>

                            <a href="{{ route('departments.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list"></i> All Departments
                            </a>
                        </div>

                        <hr>

                        <h6>Danger Zone</h6>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST"
                            onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete Department
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
