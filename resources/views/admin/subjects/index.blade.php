@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Subjects</h4>
                        <a href="{{ route('subjects.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Subject
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Search and Filter Form -->
                        <form action="{{ route('subjects.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search subjects..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="category" class="form-control">
                                        <option value="">All Categories</option>
                                        <option value="core" {{ request('category') == 'core' ? 'selected' : '' }}>Core
                                        </option>
                                        <option value="elective" {{ request('category') == 'elective' ? 'selected' : '' }}>
                                            Elective</option>
                                        <option value="extracurricular"
                                            {{ request('category') == 'extracurricular' ? 'selected' : '' }}>Extracurricular
                                        </option>
                                        <option value="vocational"
                                            {{ request('category') == 'vocational' ? 'selected' : '' }}>Vocational</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="is_active" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </form>

                        <!-- Subjects Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Credit Hours</th>
                                        <th>Difficulty</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subjects as $subject)
                                        <tr>
                                            <td><strong>{{ $subject->code }}</strong></td>
                                            <td>{{ $subject->name }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $subject->category == 'core' ? 'primary' : ($subject->category == 'elective' ? 'success' : ($subject->category == 'extracurricular' ? 'warning' : 'info')) }}">
                                                    {{ ucfirst($subject->category) }}
                                                </span>
                                            </td>
                                            <td>{{ $subject->credit_hours }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="mr-2">{{ $subject->difficulty_level }}/5</span>
                                                    <div class="progress" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar bg-{{ $subject->difficulty_level <= 2 ? 'success' : ($subject->difficulty_level <= 4 ? 'warning' : 'danger') }}"
                                                            style="width: {{ ($subject->difficulty_level / 5) * 100 }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $subject->is_active ? 'success' : 'danger' }}">
                                                    {{ $subject->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('subjects.show', $subject->id) }}"
                                                        class="btn btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('subjects.edit', $subject->id) }}"
                                                        class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('subjects.destroy', $subject->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this subject?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No subjects found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} of
                                {{ $subjects->total() }} results
                            </div>
                            {{ $subjects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
