<div id="paymentModal" class="fixed inset-0 z-50 hidden modal">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Record Payment</h3>
            </div>

            <form action="{{ route('admin.enrollments.payment', $enrollment) }}" method="POST">
                @csrf

                <div class="p-6 space-y-4">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-700">
                            Current Balance: ${{ number_format($enrollment->balance, 2) }}
                        </p>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Amount *
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                                max="{{ $enrollment->balance }}"
                                class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Maximum: ${{ number_format($enrollment->balance, 2) }}</p>
                    </div>

                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Date *
                        </label>
                        <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Method *
                        </label>
                        <select name="payment_method" id="payment_method"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Select Method</option>
                            <option value="cash">Cash</option>
                            <option value="check">Check</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="online_payment">Online Payment</option>
                        </select>
                    </div>

                    <div>
                        <label for="reference" class="block text-sm font-medium text-gray-700 mb-2">
                            Reference Number
                        </label>
                        <input type="text" name="reference" id="reference"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Check #, Transaction ID, etc.">
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('paymentModal')"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
