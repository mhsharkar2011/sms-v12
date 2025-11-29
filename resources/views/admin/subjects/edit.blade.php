@extends('layouts.app')

@section('title', 'Edit Subject')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Subject: {{ $subject->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Subject Name *</label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $subject->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Subject Code *</label>
                                        <input type="text" name="code" id="code"
                                            class="form-control @error('code') is-invalid @enderror"
                                            value="{{ old('code', $subject->code) }}" required>
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3">{{ old('description', $subject->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category *</label>
                                        <select name="category" id="category"
                                            class="form-control @error('category') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            <option value="core"
                                                {{ old('category', $subject->category) == 'core' ? 'selected' : '' }}>Core
                                            </option>
                                            <option value="elective"
                                                {{ old('category', $subject->category) == 'elective' ? 'selected' : '' }}>
                                                Elective</option>
                                            <option value="extracurricular"
                                                {{ old('category', $subject->category) == 'extracurricular' ? 'selected' : '' }}>
                                                Extracurricular</option>
                                            <option value="vocational"
                                                {{ old('category', $subject->category) == 'vocational' ? 'selected' : '' }}>
                                                Vocational</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="credit_hours">Credit Hours *</label>
                                        <input type="number" name="credit_hours" id="credit_hours"
                                            class="form-control @error('credit_hours') is-invalid @enderror"
                                            value="{{ old('credit_hours', $subject->credit_hours) }}" min="1"
                                            max="10" required>
                                        @error('credit_hours')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="difficulty_level">Difficulty Level (1-5) *</label>
                                        <select name="difficulty_level" id="difficulty_level"
                                            class="form-control @error('difficulty_level') is-invalid @enderror" required>
                                            <option value="">Select Level</option>
                                            <option value="1"
                                                {{ old('difficulty_level', $subject->difficulty_level) == '1' ? 'selected' : '' }}>
                                                1 - Very Easy</option>
                                            <option value="2"
                                                {{ old('difficulty_level', $subject->difficulty_level) == '2' ? 'selected' : '' }}>
                                                2 - Easy</option>
                                            <option value="3"
                                                {{ old('difficulty_level', $subject->difficulty_level) == '3' ? 'selected' : '' }}>
                                                3 - Moderate</option>
                                            <option value="4"
                                                {{ old('difficulty_level', $subject->difficulty_level) == '4' ? 'selected' : '' }}>
                                                4 - Difficult</option>
                                            <option value="5"
                                                {{ old('difficulty_level', $subject->difficulty_level) == '5' ? 'selected' : '' }}>
                                                5 - Very Difficult</option>
                                        </select>
                                        @error('difficulty_level')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                        {{ old('is_active', $subject->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active Subject</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Subject
                                </button>
                                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Subject Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Created:</strong> {{ $subject->created_at->format('M d, Y') }}</p>
                        <p><strong>Last Updated:</strong> {{ $subject->updated_at->format('M d, Y') }}</p>
                        <hr>
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block"
                                onclick="return confirm('Are you sure you want to delete this subject? This action cannot be undone.')">
                                <i class="fas fa-trash"></i> Delete Subject
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
