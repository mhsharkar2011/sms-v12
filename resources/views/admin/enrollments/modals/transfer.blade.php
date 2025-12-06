<div id="transferModal" class="fixed inset-0 z-50 hidden modal">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200"> <h3 class="text-lg font-semibold text-gray-900">Transfer to Another Class</h3> </div>
            <form action="{{ route('admin.enrollments.transfer', $enrollment) }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="new_class_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select New Class *
                        </label>
                        <select name="new_class_id" id="new_class_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Select Class</option>
                            @foreach (App\Models\SchoolClass::active()->where('id', '!=', $enrollment->class_id)->get() as $class)
                                @if ($class->hasAvailableSeats())
                                     <option value="{{ $class->id }}">
                                            {{ $class->name }} ({{ $class->code }}) - {{ $class->grade_level }} {{ $class->section }}
                                                 - Available: {{ $class->available_seats }}
                                        </option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="transfer_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Transfer Date *
                        </label>
                        <input type="date" name="transfer_date" id="transfer_date"
                            value="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Transfer Notes
                        </label>
                        <textarea name="notes" id="notes" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Reason for transfer..."></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('transferModal')"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Transfer Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
