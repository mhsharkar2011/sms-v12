<div id="attendanceModal" class="fixed inset-0 z-50 hidden modal">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Update Attendance</h3>
            </div>

            <form action="{{ route('admin.enrollments.attendance', $enrollment) }}" method="POST">
                @csrf

                <div class="p-6 space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-700">
                            Current Attendance: {{ $enrollment->classes_attended }} of {{ $enrollment->total_classes }}
                            classes
                            ({{ $enrollment->attendance_percentage }}%)
                        </p>
                    </div>

                    <div>
                        <label for="total_classes" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Classes Held *
                        </label>
                        <input type="number" name="total_classes" id="total_classes" min="0"
                            value="{{ $enrollment->total_classes }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="classes_attended" class="block text-sm font-medium text-gray-700 mb-2">
                            Classes Attended *
                        </label>
                        <input type="number" name="classes_attended" id="classes_attended" min="0"
                            value="{{ $enrollment->classes_attended }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <p class="mt-1 text-xs text-gray-500">
                            Cannot exceed total classes held
                        </p>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('attendanceModal')"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Update Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
