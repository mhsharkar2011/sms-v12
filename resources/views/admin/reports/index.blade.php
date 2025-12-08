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
                                <form id="dateFilterForm" method="GET" action="{{ route('admin.reports.index') }}">
                                    <select name="date_range" onchange="this.form.submit()"
                                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="7" {{ request('date_range', '7') == '7' ? 'selected' : '' }}>
                                            Last 7 Days</option>
                                        <option value="30" {{ request('date_range') == '30' ? 'selected' : '' }}>Last 30
                                            Days</option>
                                        <option value="90" {{ request('date_range') == '90' ? 'selected' : '' }}>Last 3
                                            Months</option>
                                        <option value="365" {{ request('date_range') == '365' ? 'selected' : '' }}>Last
                                            Year</option>
                                        <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>
                                            Custom Range</option>
                                    </select>
                                </form>
                            </div>
                            <button onclick="exportAllReports()"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">download</span>
                                <span>Export All</span>
                            </button>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="material-icons-sharp text-red-400">error</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    There were {{ $errors->count() }} errors with your submission
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                                @if ($studentGrowth > 0)
                                    <p class="text-xs text-green-600 mt-1">↑ {{ number_format($studentGrowth, 1) }}% from
                                        last month</p>
                                @elseif($studentGrowth < 0)
                                    <p class="text-xs text-red-600 mt-1">↓ {{ number_format(abs($studentGrowth), 1) }}%
                                        from last month</p>
                                @else
                                    <p class="text-xs text-gray-600 mt-1">No change from last month</p>
                                @endif
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
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($avgAttendance, 1) }}%</p>
                                @if ($attendanceGrowth > 0)
                                    <p class="text-xs text-green-600 mt-1">↑ {{ number_format($attendanceGrowth, 1) }}%
                                        from last month</p>
                                @elseif($attendanceGrowth < 0)
                                    <p class="text-xs text-red-600 mt-1">↓ {{ number_format(abs($attendanceGrowth), 1) }}%
                                        from last month</p>
                                @else
                                    <p class="text-xs text-gray-600 mt-1">No change from last month</p>
                                @endif
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
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($avgPassPercentage, 1) }}%</p>
                                @if ($passGrowth > 0)
                                    <p class="text-xs text-green-600 mt-1">↑ {{ number_format($passGrowth, 1) }}% from last
                                        term</p>
                                @elseif($passGrowth < 0)
                                    <p class="text-xs text-red-600 mt-1">↓ {{ number_format(abs($passGrowth), 1) }}% from
                                        last term</p>
                                @else
                                    <p class="text-xs text-gray-600 mt-1">No change from last term</p>
                                @endif
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-purple-600">emoji_events</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Revenue</p>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                                @if ($revenueGrowth > 0)
                                    <p class="text-xs text-green-600 mt-1">↑ {{ number_format($revenueGrowth, 1) }}% from
                                        last month</p>
                                @elseif($revenueGrowth < 0)
                                    <p class="text-xs text-red-600 mt-1">↓ {{ number_format(abs($revenueGrowth), 1) }}%
                                        from last month</p>
                                @else
                                    <p class="text-xs text-gray-600 mt-1">No change from last month</p>
                                @endif
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
                            <h2 class="text-xl font-bold text-gray-900">Attendance Trend (Last 5 Days)</h2>
                            <a href="{{ route('attendance.report') }}"
                                class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
                        </div>
                        <div class="h-64 flex items-end justify-between space-x-2">
                            @foreach ($attendanceTrend as $day => $attendance)
                                <div class="flex-1 flex flex-col items-center">
                                    @php
                                        $height = min(100, max(10, $attendance['percentage']));
                                        $bgColor = match (true) {
                                            $attendance['percentage'] >= 90 => 'bg-green-500',
                                            $attendance['percentage'] >= 80 => 'bg-blue-500',
                                            $attendance['percentage'] >= 70 => 'bg-yellow-500',
                                            default => 'bg-red-500',
                                        };
                                    @endphp
                                    <div class="w-full {{ $bgColor }} rounded-t-lg"
                                        style="height: {{ $height }}%">
                                        <div class="text-white text-xs text-center pt-1">{{ $attendance['percentage'] }}%
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-600 mt-2">{{ $day }}</span>
                                    <span
                                        class="text-xs text-gray-500">{{ $attendance['present'] }}/{{ $attendance['total'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Performance by Subject -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Performance by Subject</h2>
                            <a href="{{ route('academic.report') }}" class="text-sm text-blue-600 hover:text-blue-800">View
                                Details</a>
                        </div>
                        <div class="space-y-4">
                            @foreach ($subjectPerformance as $subject => $performance)
                                @php
                                    $color = match ($subject) {
                                        'Mathematics' => 'bg-green-600',
                                        'Science' => 'bg-blue-600',
                                        'English' => 'bg-purple-600',
                                        'History' => 'bg-orange-600',
                                        'Physics' => 'bg-red-600',
                                        'Chemistry' => 'bg-indigo-600',
                                        'Biology' => 'bg-teal-600',
                                        'Geography' => 'bg-pink-600',
                                        default => 'bg-gray-600',
                                    };
                                @endphp
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700">{{ $subject }}</span>
                                        <span
                                            class="font-medium text-gray-900">{{ number_format($performance['average'], 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="{{ $color }} h-2 rounded-full"
                                            style="width: {{ $performance['average'] }}%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>Students: {{ $performance['students'] }}</span>
                                        <span>Pass: {{ $performance['passed'] }}/{{ $performance['total'] }}</span>
                                    </div>
                                </div>
                            @endforeach
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
                            <a href="{{ route('academic.generate') }}"
                                class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors text-center">
                                Generate
                            </a>
                            <a href="{{ route('academic.export') }}"
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </a>
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
                            <a href="{{ route('attendance.generate') }}"
                                class="flex-1 bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700 transition-colors text-center">
                                Generate
                            </a>
                            <a href="{{ route('attendance.export') }}"
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </a>
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
                            <a href="{{ route('finance.generate') }}"
                                class="flex-1 bg-purple-600 text-white py-2 rounded-lg text-sm hover:bg-purple-700 transition-colors text-center">
                                Generate
                            </a>
                            <a href="{{ route('finance.export') }}"
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </a>
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
                            <a href="{{ route('exams.generate') }}"
                                class="flex-1 bg-orange-600 text-white py-2 rounded-lg text-sm hover:bg-orange-700 transition-colors text-center">
                                Generate
                            </a>
                            <a href="{{ route('exams.export') }}"
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </a>
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
                            <a href="{{ route('staff.generate') }}"
                                class="flex-1 bg-red-600 text-white py-2 rounded-lg text-sm hover:bg-red-700 transition-colors text-center">
                                Generate
                            </a>
                            <a href="{{ route('staff.export') }}"
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </a>
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
                            <a href="{{ route('inventory.generate') }}"
                                class="flex-1 bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700 transition-colors text-center">
                                Generate
                            </a>
                            <a href="{{ route('inventory.export') }}"
                                class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600 text-sm">download</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Generated Reports -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Reports</h2>
                        <a href="{{ route('reports.history') }}" class="text-sm text-blue-600 hover:text-blue-800">View
                            All Reports</a>
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
                                @forelse($recentReports as $report)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6 font-medium text-gray-900">{{ $report->name }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-900">{{ ucfirst($report->type) }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-900">
                                            {{ $report->created_at->format('M d, Y') }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-900">{{ $report->period }}</td>
                                        <td class="py-4 px-6">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                {{ $report->status == 'completed'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($report->status == 'processing'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-2">
                                                @if ($report->status == 'completed')
                                                    <a href="{{ route('reports.view', $report->id) }}"
                                                        class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                                        <span class="material-icons-sharp text-sm">visibility</span>
                                                    </a>
                                                    <a href="{{ route('reports.download', $report->id) }}"
                                                        class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors">
                                                        <span class="material-icons-sharp text-sm">download</span>
                                                    </a>
                                                @else
                                                    <button disabled
                                                        class="w-8 h-8 bg-gray-100 text-gray-400 rounded-lg flex items-center justify-center cursor-not-allowed">
                                                        <span class="material-icons-sharp text-sm">visibility</span>
                                                    </button>
                                                    <button disabled
                                                        class="w-8 h-8 bg-gray-100 text-gray-400 rounded-lg flex items-center justify-center cursor-not-allowed">
                                                        <span class="material-icons-sharp text-sm">download</span>
                                                    </button>
                                                @endif
                                                <form action="{{ route('reports.delete', $report->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this report?')"
                                                        class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                                                        <span class="material-icons-sharp text-sm">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <span
                                                    class="material-icons-sharp text-4xl text-gray-300 mb-2">description</span>
                                                <p class="text-gray-600">No reports generated yet</p>
                                                <p class="text-sm text-gray-500 mt-1">Generate your first report using the
                                                    buttons above</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($recentReports->hasPages())
                            <div class="mt-4 px-6">
                                {{ $recentReports->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Custom Report Generator Modal -->
                <div id="customReportModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50">
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Generate Custom Report</h3>
                                    <button onclick="closeCustomReportModal()" class="text-gray-400 hover:text-gray-600">
                                        <span class="material-icons-sharp">close</span>
                                    </button>
                                </div>
                                <form id="customReportForm" method="POST" action="{{ route('reports.custom') }}">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                                            <select name="report_type" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Report Type</option>
                                                <option value="academic">Academic Report</option>
                                                <option value="attendance">Attendance Report</option>
                                                <option value="finance">Financial Report</option>
                                                <option value="exam">Examination Report</option>
                                                <option value="staff">Staff Report</option>
                                                <option value="inventory">Inventory Report</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Report Name</label>
                                            <input type="text" name="report_name" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Enter report name">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="date" name="start_date" required
                                                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <input type="date" name="end_date" required
                                                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                                            <div class="flex space-x-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="format" value="pdf" checked
                                                        class="form-radio text-blue-600">
                                                    <span class="ml-2">PDF</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="format" value="excel"
                                                        class="form-radio text-green-600">
                                                    <span class="ml-2">Excel</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="format" value="csv"
                                                        class="form-radio text-purple-600">
                                                    <span class="ml-2">CSV</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex justify-end space-x-3">
                                        <button type="button" onclick="closeCustomReportModal()"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            Generate Report
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date inputs
            const today = new Date().toISOString().split('T')[0];
            const lastWeek = new Date();
            lastWeek.setDate(lastWeek.getDate() - 7);
            const lastWeekFormatted = lastWeek.toISOString().split('T')[0];

            document.querySelector('input[name="start_date"]').value = lastWeekFormatted;
            document.querySelector('input[name="end_date"]').value = today;

            // Check if custom date range is selected
            if (document.querySelector('select[name="date_range"]').value === 'custom') {
                showCustomDateRange();
            }

            // Report generation with progress tracking
            const generateButtons = document.querySelectorAll('a[href*="generate"]');

            generateButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.href.includes('generate')) return;

                    e.preventDefault();
                    const reportType = this.closest('.bg-white').querySelector('h3').textContent;

                    // Show loading state
                    const originalHTML = this.innerHTML;
                    this.innerHTML =
                        '<span class="material-icons-sharp text-sm animate-spin">autorenew</span> Generating...';
                    this.disabled = true;

                    // Make AJAX request
                    fetch(this.href, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification(`${reportType} generated successfully!`,
                                    'success');
                                // Refresh the page after 2 seconds to show new report
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                showNotification(data.message || 'Failed to generate report',
                                    'error');
                            }
                        })
                        .catch(error => {
                            showNotification('Error generating report', 'error');
                            console.error('Error:', error);
                        })
                        .finally(() => {
                            this.innerHTML = originalHTML;
                            this.disabled = false;
                        });
                });
            });

            // Export all reports functionality
            window.exportAllReports = function() {
                if (!confirm('Export all recent reports?')) return;

                showNotification('Preparing export package...', 'info');

                fetch('{{ route('reports.export.all') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `all-reports-${new Date().toISOString().split('T')[0]}.zip`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        showNotification('Export completed successfully!', 'success');
                    })
                    .catch(error => {
                        showNotification('Export failed', 'error');
                        console.error('Error:', error);
                    });
            };

            // Custom report modal functions
            window.openCustomReportModal = function() {
                document.getElementById('customReportModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            };

            window.closeCustomReportModal = function() {
                document.getElementById('customReportModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            };

            // Custom date range functionality
            window.showCustomDateRange = function() {
                const modal = document.createElement('div');
                modal.className =
                    'fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Custom Date Range</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" id="customStartDate" class="border border-gray-300 rounded-lg px-3 py-2">
                                <input type="date" id="customEndDate" class="border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                                <button onclick="applyCustomDateRange()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Apply</button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);

                // Set default dates
                const endDate = new Date().toISOString().split('T')[0];
                const startDate = new Date();
                startDate.setDate(startDate.getDate() - 30);
                document.getElementById('customStartDate').value = startDate.toISOString().split('T')[0];
                document.getElementById('customEndDate').value = endDate;
            };

            window.applyCustomDateRange = function() {
                const startDate = document.getElementById('customStartDate').value;
                const endDate = document.getElementById('customEndDate').value;

                if (!startDate || !endDate) {
                    showNotification('Please select both start and end dates', 'error');
                    return;
                }

                // Submit form with custom dates
                const form = document.getElementById('dateFilterForm');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'custom_start';
                input.value = startDate;
                form.appendChild(input);

                const input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'custom_end';
                input2.value = endDate;
                form.appendChild(input2);

                form.submit();
            };

            // Custom report form submission
            document.getElementById('customReportForm')?.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.innerHTML =
                    '<span class="material-icons-sharp text-sm animate-spin">autorenew</span> Generating...';
                submitBtn.disabled = true;

                fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Custom report generated successfully!', 'success');
                            closeCustomReportModal();
                            // Refresh page to show new report
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showNotification(data.message || 'Failed to generate report', 'error');
                        }
                    })
                    .catch(error => {
                        showNotification('Error generating report', 'error');
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    });
            });

            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white ${
                    type === 'success' ? 'bg-green-500' :
                    type === 'error' ? 'bg-red-500' :
                    'bg-blue-500'
                } transform translate-x-full transition-transform duration-300 z-50`;
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

            // Date range filter change handler
            document.querySelector('select[name="date_range"]')?.addEventListener('change', function() {
                if (this.value === 'custom') {
                    showCustomDateRange();
                    return false;
                }
                this.form.submit();
            });

            // Real-time updates for key metrics
            function updateMetrics() {
                fetch('{{ route('reports.metrics') }}')
                    .then(response => response.json())
                    .then(data => {
                        // Update metrics on the page
                        document.querySelectorAll('.bg-white.rounded-xl.shadow-sm.p-6').forEach((card,
                            index) => {
                            const valueElements = card.querySelectorAll('.text-2xl.font-bold');
                            const changeElements = card.querySelectorAll('.text-xs');

                            if (index === 0 && data.totalStudents) {
                                valueElements[0].textContent = data.totalStudents;
                                updateChangeText(changeElements[0], data.studentGrowth);
                            }
                            if (index === 1 && data.avgAttendance) {
                                valueElements[1].textContent = data.avgAttendance + '%';
                                updateChangeText(changeElements[1], data.attendanceGrowth);
                            }
                            if (index === 2 && data.avgPassPercentage) {
                                valueElements[2].textContent = data.avgPassPercentage + '%';
                                updateChangeText(changeElements[2], data.passGrowth);
                            }
                            if (index === 3 && data.totalRevenue) {
                                valueElements[3].textContent = '$' + data.totalRevenue;
                                updateChangeText(changeElements[3], data.revenueGrowth);
                            }
                        });
                    })
                    .catch(error => console.error('Error updating metrics:', error));
            }

            function updateChangeText(element, growth) {
                if (growth > 0) {
                    element.innerHTML = `↑ ${growth.toFixed(1)}% from last period`;
                    element.className = 'text-xs text-green-600 mt-1';
                } else if (growth < 0) {
                    element.innerHTML = `↓ ${Math.abs(growth).toFixed(1)}% from last period`;
                    element.className = 'text-xs text-red-600 mt-1';
                } else {
                    element.innerHTML = 'No change from last period';
                    element.className = 'text-xs text-gray-600 mt-1';
                }
            }

            // Update metrics every 5 minutes
            setInterval(updateMetrics, 300000);
        });
    </script>
@endpush
