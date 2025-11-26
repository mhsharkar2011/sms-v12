@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-student-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Messages</h1>
                <p class="text-gray-600 mt-2">Communicate with teachers and classmates</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Conversations List -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-gray-900">Conversations</h2>
                            <button class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <span class="material-icons-sharp text-sm">add</span>
                            </button>
                        </div>

                        <!-- Search -->
                        <div class="relative mb-4">
                            <input type="text" placeholder="Search messages..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="material-icons-sharp absolute left-3 top-2.5 text-gray-400 text-lg">search</span>
                        </div>

                        <!-- Conversation List -->
                        <div class="space-y-2">
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons-sharp text-blue-600">person</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 text-sm">Mr. Johnson</h3>
                                    <p class="text-xs text-gray-600 truncate">About the science project deadline...</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500">2m ago</span>
                                    <span class="w-2 h-2 bg-blue-600 rounded-full block mt-1 ml-auto"></span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons-sharp text-green-600">groups</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 text-sm">Class 10-A Group</h3>
                                    <p class="text-xs text-gray-600 truncate">Sarah: Don't forget the homework...</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500">1h ago</span>
                                    <span class="w-2 h-2 bg-red-500 rounded-full block mt-1 ml-auto"></span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons-sharp text-purple-600">person</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 text-sm">Ms. Davis</h3>
                                    <p class="text-xs text-gray-600 truncate">Math test rescheduled to Friday</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500">3h ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm h-[600px] flex flex-col">
                        <!-- Chat Header -->
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons-sharp text-blue-600">person</span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Mr. Johnson</h3>
                                    <p class="text-xs text-gray-500">Science Teacher • Online</p>
                                </div>
                            </div>
                        </div>

                        <!-- Messages -->
                        <div class="flex-1 p-4 overflow-y-auto space-y-4">
                            <!-- Received Message -->
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="material-icons-sharp text-blue-600 text-sm">person</span>
                                </div>
                                <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                                    <p class="text-sm text-gray-900">Hi there! I wanted to remind you about the science project deadline this Friday.</p>
                                    <span class="text-xs text-gray-500 mt-1 block">2:30 PM</span>
                                </div>
                            </div>

                            <!-- Sent Message -->
                            <div class="flex items-start space-x-3 justify-end">
                                <div class="bg-blue-600 rounded-lg p-3 max-w-xs">
                                    <p class="text-sm text-white">Thank you for the reminder! I'm almost done with my project.</p>
                                    <span class="text-xs text-blue-200 mt-1 block">2:31 PM</span>
                                </div>
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="material-icons-sharp text-gray-600 text-sm">person</span>
                                </div>
                            </div>

                            <!-- Received Message -->
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="material-icons-sharp text-blue-600 text-sm">person</span>
                                </div>
                                <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                                    <p class="text-sm text-gray-900">Great to hear! Let me know if you need any help with the final presentation.</p>
                                    <span class="text-xs text-gray-500 mt-1 block">2:32 PM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Message Input -->
                        <div class="p-4 border-t border-gray-200">
                            <div class="flex items-center space-x-3">
                                <button class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                                    <span class="material-icons-sharp text-gray-600 text-lg">add</span>
                                </button>
                                <input type="text" placeholder="Type a message..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <button class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                                    <span class="material-icons-sharp text-lg">send</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
