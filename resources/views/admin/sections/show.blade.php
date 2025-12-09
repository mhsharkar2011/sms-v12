{{-- resources/views/sections/show.blade.php --}}
@extends('layouts.app')

@section('title', $section->name . ' - Section Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column: Section Details -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Section Information</h5>
                        <span class="badge bg-{{ $section->is_active ? 'success' : 'danger' }}">
                            {{ $section->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="section-icon bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-users fa-2x text-white"></i>
                            </div>
                            <h4 class="mt-3">{{ $section->name }}</h4>
                            <h5 class="text-muted">{{ $section->code }}</h5>
                        </div>

                        <div class="section-details">
                            <div class="detail-item mb-3">
                                <label class="text-muted small mb-1">Class</label>
                                <p class="mb-0">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                                    {{ $section->class->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="detail-item mb-3">
                                <label class="text-muted small mb-1">Class Teacher</label>
                                <p class="mb-0">
                                    <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                                    {{ $section->teacher->full_name ?? 'Not Assigned' }}
                                </p>
                            </div>

                            <div class="detail-item mb-3">
                                <label class="text-muted small mb-1">Capacity & Enrollment</label>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <div class="progress" style="height: 10px;">
                                            @php
                                                $percentage = ($section->students->count() / $section->capacity) * 100;
                                                $bgClass =
                                                    $percentage >= 90
                                                        ? 'bg-danger'
                                                        : ($percentage >= 75
                                                            ? 'bg-warning'
                                                            : 'bg-success');
                                            @endphp
                                            <div class="progress-bar {{ $bgClass }}" role="progressbar"
                                                style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-dark">
                                        {{ $section->students->count() }}/{{ $section->capacity }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    {{ $section->remaining_seats }} seats remaining
                                    @if ($section->is_full)
                                        <span class="text-danger">(Section Full)</span>
                                    @endif
                                </small>
                            </div>

                            <div class="detail-item mb-3">
                                <label class="text-muted small mb-1">Description</label>
                                <p class="mb-0">
                                    {{ $section->description ?? 'No description provided.' }}
                                </p>
                            </div>

                            <div class="detail-item mb-3">
                                <label class="text-muted small mb-1">Created</label>
                                <p class="mb-0">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    {{ $section->created_at->format('M d, Y') }}
                                </p>
                            </div>

                            <div class="detail-item">
                                <label class="text-muted small mb-1">Last Updated</label>
                                <p class="mb-0">
                                    <i class="fas fa-history text-primary me-2"></i>
                                    {{ $section->updated_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Section
                            </a>
                            <form action="{{ route('admin.sections.toggle-status', $section) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn btn-{{ $section->is_active ? 'secondary' : 'success' }} w-100">
                                    <i class="fas fa-{{ $section->is_active ? 'toggle-off' : 'toggle-on' }}"></i>
                                    {{ $section->is_active ? 'Deactivate' : 'Activate' }} Section
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Students List -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Students in this Section ({{ $section->students->count() }})</h5>
                        <a href="{{ route('students.create', ['section_id' => $section->id]) }}"
                            class="btn btn-primary btn-sm" {{ $section->is_full ? 'disabled' : '' }}>
                            <i class="fas fa-user-plus"></i> Add Student
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($section->students->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Enrollment Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($section->students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $student->student_id }}</strong></td>
                                                <td>{{ $student->full_name }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->phone ?? 'N/A' }}</td>
                                                <td>{{ $student->enrollment_date->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('students.show', $student) }}"
                                                        class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                <h5>No Students Assigned</h5>
                                <p class="text-muted">This section doesn't have any students yet.</p>
                                <a href="{{ route('students.create', ['section_id' => $section->id]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i> Add First Student
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .section-details .detail-item {
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .section-details .detail-item:last-child {
            border-bottom: none;
        }

        .section-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endsection
