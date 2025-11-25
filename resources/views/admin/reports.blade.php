@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Reports & Analytics</h1>
                            <p class="text-gray-600 mt-2">Generate comprehensive reports and view analytics</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <select
                                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option>Last 7 Days</option>
                                    <option>Last 30 Days</option>
                                    <option>Last 3 Months</option>
                                    <option>Last Year</option>
                                    <option>Custom Range</option>
                                </select>
                            </div>
                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">download</span>
                                <span>Export All</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-gray-900">1,247</p>
                                <p class="text-xs text-green-600 mt-1">↑ 5.2% from last month</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-blue-600">school</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Attendance Rate</p>
                                <p class="text-2xl font-bold text-gray-900">94.2%</p>
                                <p class="text-xs text-green-600 mt-1">↑ 2.1% from last month</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-green-600">trending_up</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Pass Percentage</p>
                                <p class="text-2xl font-bold text-gray-900">87.5%</p>
                                <p class="text-xs text-green-600 mt-1">↑ 3.8% from last term</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-purple-600">emoji_events</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Revenue</p>
                                <p class="text-2xl font-bold text-gray-900">$248,750</p>
                                <p class="text-xs text-green-600 mt-1">↑ 12.5% from last year</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-orange-600">attach_money</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Attendance Trend -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Attendance Trend</h2>
                            <div class="flex items-center space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">View Details</button>
                            </div>
                        </div>
                        <div class="h-64 flex items-end justify-between space-x-2">
                            <!-- Simple bar chart representation -->
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-200 rounded-t-lg" style="height: 80%"></div>
                                <span class="text-xs text-gray-600 mt-2">Mon</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-300 rounded-t-lg" style="height: 85%"></div>
                                <span class="text-xs text-gray-600 mt-2">Tue</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-400 rounded-t-lg" style="height: 92%"></div>
                                <span class="text-xs text-gray-600 mt-2">Wed</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 rounded-t-lg" style="height: 88%"></div>
                                <span class="text-xs text-gray-600 mt-2">Thu</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-600 rounded-t-lg" style="height: 95%"></div>
                                <span class="text-xs text-gray-600 mt-2">Fri</span>
                            </div>
                        </div>
                    </div>

                    <!-- Performance by Subject -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Performance by Subject</h2>
                            <div class="flex items-center space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">View Details</button>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-700">Mathematics</span>
                                    <span class="font-medium text-gray-900">92%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 92%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-700">Science</span>
                                    <span class="font-medium text-gray-900">85%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-700">English</span>
                                    <span class="font-medium text-gray-900">78%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-700">History</span>
                                    <span class="font-medium text-gray-900">88%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-600 h-2 rounded-full" style="width: 88%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Types Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Academic Reports -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <span class="material-icons-sharp text-blue-600">school</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Academic Reports</h3>
                        <p class="text-sm text-gray-600 mb-4">Student performance, grades, and progress reports</p>
                        <div class="flex space-x-2">
                            <button
                                class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                Generate
                            </button>
                            <button
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </button>
                        </div>
                    </div>

                    <!-- Attendance Reports -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <span class="material-icons-sharp text-green-600">calendar_today</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Attendance Reports</h3>
                        <p class="text-sm text-gray-600 mb-4">Student and teacher attendance analytics</p>
                        <div class="flex space-x-2">
                            <button
                                class="flex-1 bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700 transition-colors">
                                Generate
                            </button>
                            <button
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </button>
                        </div>
                    </div>

                    <!-- Financial Reports -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <span class="material-icons-sharp text-purple-600">payments</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Financial Reports</h3>
                        <p class="text-sm text-gray-600 mb-4">Fee collection, expenses, and financial analytics</p>
                        <div class="flex space-x-2">
                            <button
                                class="flex-1 bg-purple-600 text-white py-2 rounded-lg text-sm hover:bg-purple-700 transition-colors">
                                Generate
                            </button>
                            <button
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </button>
                        </div>
                    </div>

                    <!-- Examination Reports -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                            <span class="material-icons-sharp text-orange-600">quiz</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Examination Reports</h3>
                        <p class="text-sm text-gray-600 mb-4">Exam results, analysis, and statistics</p>
                        <div class="flex space-x-2">
                            <button
                                class="flex-1 bg-orange-600 text-white py-2 rounded-lg text-sm hover:bg-orange-700 transition-colors">
                                Generate
                            </button>
                            <button
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </button>
                        </div>
                    </div>

                    <!-- Staff Reports -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                            <span class="material-icons-sharp text-red-600">groups</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Staff Reports</h3>
                        <p class="text-sm text-gray-600 mb-4">Teacher performance and staff analytics</p>
                        <div class="flex space-x-2">
                            <button
                                class="flex-1 bg-red-600 text-white py-2 rounded-lg text-sm hover:bg-red-700 transition-colors">
                                Generate
                            </button>
                            <button
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </button>
                        </div>
                    </div>

                    <!-- Inventory Reports -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <span class="material-icons-sharp text-indigo-600">inventory</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Inventory Reports</h3>
                        <p class="text-sm text-gray-600 mb-4">School assets and inventory management</p>
                        <div class="flex space-x-2">
                            <button
                                class="flex-1 bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700 transition-colors">
                                Generate
                            </button>
                            <button
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Generated Reports -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Reports</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All Reports</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Report Name</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Type</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Generated On</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Period</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Status</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Monthly Attendance Summary</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Attendance</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">March 1, 2024</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Feb 2024</td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <button
                                                class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                                <span class="material-icons-sharp text-sm">visibility</span>
                                            </button>
                                            <button
                                                class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors">
                                                <span class="material-icons-sharp text-sm">download</span>
                                            </button>
                                            <button
                                                class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                                                <span class="material-icons-sharp text-sm">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Term 1 Exam Results</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Examination</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Feb 28, 2024</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Term 1 2024</td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <button
                                                class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                                <span class="material-icons-sharp text-sm">visibility</span>
                                            </button>
                                            <button
                                                class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors">
                                                <span class="material-icons-sharp text-sm">download</span>
                                            </button>
                                            <button
                                                class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                                                <span class="material-icons-sharp text-sm">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Financial Quarter Report</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Financial</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Feb 25, 2024</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Q1 2024</td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            Processing
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <button
                                                class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                                <span class="material-icons-sharp text-sm">visibility</span>
                                            </button>
                                            <button
                                                class="w-8 h-8 bg-gray-100 text-gray-400 rounded-lg flex items-center justify-center cursor-not-allowed">
                                                <span class="material-icons-sharp text-sm">download</span>
                                            </button>
                                        </div>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Report generation functionality
            const generateButtons = document.querySelectorAll('button:contains("Generate")');

            generateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const reportType = this.closest('.bg-white').querySelector('h3').textContent;

                    // Show loading state
                    const originalText = this.textContent;
                    this.innerHTML =
                        '<span class="material-icons-sharp text-sm animate-spin">autorenew</span> Generating...';
                    this.disabled = true;

                    // Simulate report generation
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.disabled = false;

                        // Show success message
                        showNotification(`${reportType} generated successfully!`,
                        'success');
                    }, 2000);
                });
            });

            // Download functionality
            const downloadButtons = document.querySelectorAll('button:contains("download")');

            downloadButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const reportRow = this.closest('tr');
                    const reportName = reportRow ? reportRow.querySelector('td').textContent :
                        'Report';

                    showNotification(`Downloading ${reportName}...`, 'info');
                });
            });

            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            'bg-blue-500'
        } transform translate-x-full transition-transform duration-300`;
                notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="material-icons-sharp">${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info'}</span>
                <span>${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Date range filter functionality
            const dateFilter = document.querySelector('select');
            if (dateFilter) {
                dateFilter.addEventListener('change', function() {
                    const selectedRange = this.value;
                    showNotification(`Filtering reports for: ${selectedRange}`, 'info');

                    // Here you would typically make an API call to filter reports
                    // For now, we'll just simulate loading
                    simulateLoading();
                });
            }

            function simulateLoading() {
                const tables = document.querySelectorAll('table');
                tables.forEach(table => {
                    table.style.opacity = '0.5';
                });

                setTimeout(() => {
                    tables.forEach(table => {
                        table.style.opacity = '1';
                    });
                }, 1000);
            }
        });
    </script>
@endpush
