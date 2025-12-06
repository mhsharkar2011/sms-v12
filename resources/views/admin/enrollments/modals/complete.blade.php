<div id="completeModal" class="fixed inset-0 z-50 hidden modal">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Complete Enrollment</h3>
            </div>

            <form action="{{ route('admin.enrollments.complete', $enrollment) }}" method="POST">
                @csrf

                <div class="p-6 space-y-4">
                    <div>
                        <label for="final_grade" class="block text-sm font-medium text-gray-700 mb-2">
                            Final Grade (0-100) *
                        </label>
                        <input type="number" name="final_grade" id="final_grade" step="0.01" min="0"
                            max="100"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="grade_letter" class="block text-sm font-medium text-gray-700 mb-2">
                            Grade Letter *
                        </label>
                        <select name="grade_letter" id="grade_letter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Select Grade</option>
                            <option value="A+">A+</option>
                            <option value="A">A</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B">B</option>
                            <option value="B-">B-</option>
                            <option value="C+">C+</option>
                            <option value="C">C</option>
                            <option value="C-">C-</option>
                            <option value="D+">D+</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                        </select>
                    </div>

                    <div>
                        <label for="gpa" class="block text-sm font-medium text-gray-700 mb-2">
                            GPA (0-4.0)
                        </label>
                        <input type="number" name="gpa" id="gpa" step="0.01" min="0" max="4"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Completion Date *
                        </label>
                        <input type="date" name="end_date" id="end_date" value="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('completeModal')"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Complete Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
