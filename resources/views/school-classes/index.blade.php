{{-- resources/views/school-classes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'School Classes')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">School Classes</h1>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">Create Class</a>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Search / Filters --}}
        <form class="mb-3" method="GET" action="{{ route('school-classes.index') }}">
            <div class="row g-2">
                <div class="col-sm-8 col-md-6">
                    <input type="search" name="q" class="form-control" value="{{ request('q') }}"
                        placeholder="Search classes by name, level or teacher">
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                    <a href="{{ route('school-classes.index') }}" class="btn btn-link">Reset</a>
                </div>
            </div>
        </form>

        @if ($schoolClasses->count())
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Teacher</th>
                            <th class="text-center">Students</th>
                            <th>Created</th>
                            <th style="width: 160px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schoolClasses as $class)
                            <tr>
                                <td>{{ $class->id }}</td>
                                <td>
                                    <a href="{{ route('school-classes.show', $class) }}" class="text-decoration-none">
                                        {{ $class->name }}
                                    </a>
                                </td>
                                <td>{{ $class->level ?? '—' }}</td>
                                <td>{{ optional($class->teacher)->name ?? '—' }}</td>
                                <td class="text-center">
                                    {{-- prefer eager-loaded students_count if available --}}
                                    {{ $class->students_count ?? ($class->students->count() ?? 0) }}
                                </td>
                                <td>{{ $class->created_at ? $class->created_at->format('Y-m-d') : '—' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('school-classes.edit', $class) }}"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="{{ route('school-classes.show', $class) }}"
                                        class="btn btn-sm btn-outline-info">View</a>

                                    <form id="delete-form-{{ $class->id }}"
                                        action="{{ route('school-classes.destroy', $class) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="if(confirm('Delete class \"{{ addslashes($class->name) }}\"? This cannot be undone.')) { document.getElementById('delete-form-{{ $class->id }}').submit(); }">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- pagination --}}
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Showing {{ $schoolClasses->firstItem() ?? 0 }} to
                    {{ $schoolClasses->lastItem() ?? 0 }} of {{ $schoolClasses->total() ?? $schoolClasses->count() }}
                    results</div>
                <div>
                    {{ $schoolClasses->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center">
                    <p class="mb-2">No classes found.</p>
                    <a href="{{ route('school-classes.create') }}" class="btn btn-primary">Create the first class</a>
                </div>
            </div>
        @endif
    </div>
@endsection
