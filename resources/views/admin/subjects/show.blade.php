@extends('layouts.app')

@section('title', $subject->name)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Subject Details</h4>
                        <div class="btn-group">
                            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Subject Code:</th>
                                        <td><strong>{{ $subject->code }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Subject Name:</th>
                                        <td>{{ $subject->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>
                                            <span
                                                class="badge badge-{{ $subject->category == 'core' ? 'primary' : ($subject->category == 'elective' ? 'success' : ($subject->category == 'extracurricular' ? 'warning' : 'info')) }}">
                                                {{ ucfirst($subject->category) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Credit Hours:</th>
                                        <td>{{ $subject->credit_hours }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Difficulty Level:</th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="mr-2">{{ $subject->difficulty_level }}/5</span>
                                                <div class="progress" style="width: 100px; height: 10px;">
                                                    <div class="progress-bar bg-{{ $subject->difficulty_level <= 2 ? 'success' : ($subject->difficulty_level <= 4 ? 'warning' : 'danger') }}"
                                                        style="width: {{ ($subject->difficulty_level / 5) * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge badge-{{ $subject->is_active ? 'success' : 'danger' }}">
                                                {{ $subject->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ $subject->created_at->format('M d, Y \a\t h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated:</th>
                                        <td>{{ $subject->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($subject->description)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5>Description</h5>
                                    <div class="border rounded p-3 bg-light">
                                        {{ $subject->description }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Additional information or actions can go here -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Subject
                            </a>
                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Are you sure you want to delete this subject?')">
                                    <i class="fas fa-trash"></i> Delete Subject
                                </button>
                            </form>
                            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list"></i> View All Subjects
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Subject Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <div class="h2 text-primary">{{ $subject->credit_hours }}</div>
                                <div class="text-muted">Credit Hours</div>
                            </div>
                            <div class="mb-3">
                                <div
                                    class="h4 text-{{ $subject->difficulty_level <= 2 ? 'success' : ($subject->difficulty_level <= 4 ? 'warning' : 'danger') }}">
                                    Level {{ $subject->difficulty_level }}
                                </div>
                                <div class="text-muted">Difficulty</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
