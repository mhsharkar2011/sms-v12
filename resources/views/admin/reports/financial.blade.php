@extends('layouts.app')

@section('title', 'Financial Reports')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Financial Reports</h1>
                            <p class="text-gray-600 mt-2">School financial performance and fee management</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <select
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Q1 2024</option>
                                <option>Q2 2024</option>
                                <option>Q3 2024</option>
                                <option>Q4 2024</option>
                            </select>
                            <button
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">receipt</span>
                                <span>Generate Statement</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Financial Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Revenue</p>
                                <p class="text-2xl font-bold text-gray-900">$248,750</p>
                                <p class="text-xs text-green-600 mt-1">↑ 12.5% from last quarter</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-green-600">trending_up</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Fee Collection</p>
                                <p class="text-2xl font-bold text-gray-900">94.8%</p>
                                <p class="text-xs text-green-600 mt-1">↑ 3.2% from last month</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-blue-600">payments</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Pending Fees</p>
                                <p class="text-2xl font-bold text-gray-900">$12,850</p>
                                <p class="text-xs text-red-600 mt-1">5.2% of total</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-red-600">pending</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Operating Costs</p>
                                <p class="text-2xl font-bold text-gray-900">$187,200</p>
                                <p class="text-xs text-orange-600 mt-1">75.2% of revenue</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-orange-600">savings</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fee Collection Details -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Fee Collection Summary</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Grade</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Total Students</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Fee Amount</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Collected</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Pending</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Collection Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Grade 10</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">350</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">$87,500</td>
                                    <td class="py-4 px-6 text-sm font-bold text-green-600">$84,125</td>
                                    <td class="py-4 px-6 text-sm font-bold text-red-600">$3,375</td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            96.1%
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Grade 9</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">320</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">$80,000</td>
                                    <td class="py-4 px-6 text-sm font-bold text-green-600">$76,800</td>
                                    <td class="py-4 px-6 text-sm font-bold text-red-600">$3,200</td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            96.0%
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Grade 8</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">300</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">$75,000</td>
                                    <td class="py-4 px-6 text-sm font-bold text-green-600">$70,500</td>
                                    <td class="py-4 px-6 text-sm font-bold text-red-600">$4,500</td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            94.0%
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
