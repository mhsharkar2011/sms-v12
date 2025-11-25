@extends('layouts.app')

@section('title', 'Students Management')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-admin-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Students Management</h1>
                <p class="text-gray-600 mt-2">Manage student records and information</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <p class="text-gray-600">Students management interface will be displayed here.</p>
            </div>
        </div>
    </div>
</div>
@endsection
