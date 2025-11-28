@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Class</h1>
    <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Class Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $class->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description', $class->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Class</button>
    </form>
</div>
@endsection
