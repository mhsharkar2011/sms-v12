<div id="withdrawModal" class="fixed inset-0 z-50 hidden modal">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Withdraw Student</h3>
            </div>

            <form action="{{ route('admin.enrollments.withdraw', $enrollment) }}" method="POST">
                @csrf

                <div class="p-6 space-y-4">
                    <div>
                        <label for="withdrawal_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for Withdrawal *
                        </label>
                        <textarea name="withdrawal_reason" id="withdrawal_reason" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required></textarea>
                    </div>

                    <div>
                        <label for="withdrawal_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Withdrawal Date *
                        </label>
                        <input type="date" name="withdrawal_date" id="withdrawal_date" value="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('withdrawModal')"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Confirm Withdrawal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
