@extends('layouts.app')

@section('title', 'Homework')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-student-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Homework</h1>
                <p class="text-gray-600 mt-2">Manage your assignments and homework</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <!-- Homework content -->
                <p class="text-gray-600">Homework assignments will be displayed here.</p>
            </div>
        </div>
    </div>
</div>
@endsection
