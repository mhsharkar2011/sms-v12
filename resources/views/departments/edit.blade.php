@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Department: {{ $department->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('departments.update', $department) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Department Name *</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $department->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Department Code *</label>
                                <input type="text" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $department->code) }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="4">{{ old('description', $department->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                        {{ old('is_active', $department->is_active) ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label">
                                        Active Department
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                                <div>
                                    <a href="{{ route('departments.show', $department) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Department
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
