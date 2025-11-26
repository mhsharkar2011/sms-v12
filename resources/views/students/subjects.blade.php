@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-student-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Subjects</h1>
                <p class="text-gray-600 mt-2">Your enrolled subjects and progress</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <!-- Subjects content -->
                <p class="text-gray-600">Subjects will be displayed here.</p>
            </div>
        </div>
    </div>
</div>
@endsection
