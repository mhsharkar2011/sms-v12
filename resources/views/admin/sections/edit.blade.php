{{-- resources/views/sections/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Section')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Section: {{ $section->name }}</h5>
                        <span class="badge bg-info">{{ $section->code }}</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sections.update', $section) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Section Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Section Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $section->name) }}"
                                        placeholder="e.g., Morning Shift" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Section Code -->
                                <div class="col-md-6">
                                    <label for="code" class="form-label">Section Code *</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="code" name="code" value="{{ old('code', $section->code) }}"
                                        placeholder="e.g., SEC-A" required>
                                    <small class="text-muted">Unique code for the section</small>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Class Selection -->
                                <div class="col-md-6">
                                    <label for="class_id" class="form-label">Class *</label>
                                    <select class="form-select @error('class_id') is-invalid @enderror" id="class_id"
                                        name="class_id" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ (old('class_id') ?? $section->class_id) == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Teacher Assignment -->
                                <div class="col-md-6">
                                    <label for="teacher_id" class="form-label">Class Teacher</label>
                                    <select class="form-select @error('teacher_id') is-invalid @enderror" id="teacher_id"
                                        name="teacher_id">
                                        <option value="">Not Assigned</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                {{ (old('teacher_id') ?? $section->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->full_name }} ({{ $teacher->subject ?? 'General' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Capacity -->
                                <div class="col-md-6">
                                    <label for="capacity" class="form-label">Capacity *</label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                        id="capacity" name="capacity" value="{{ old('capacity', $section->capacity) }}"
                                        min="{{ $section->students->count() }}" max="100" required>
                                    <small class="text-muted">
                                        Current students: {{ $section->students->count() }} |
                                        Min capacity must be {{ $section->students->count() }}
                                    </small>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1"
                                            {{ old('is_active') ?? $section->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Section
                                        </label>
                                    </div>
                                    <small class="text-muted">Inactive sections won't be available for student
                                        enrollment</small>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3" placeholder="Optional section description...">{{ old('description', $section->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('admin.sections.show', $section) }}" class="btn btn-info">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <div>
                                    <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check"></i> Update Section
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
