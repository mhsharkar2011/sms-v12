<!-- resources/views/admin/classes/partials/form-fields.blade.php -->
@csrf

@if (isset($class))
    @method('PUT')
@endif

<!-- Basic Information Section -->
<div class="p-6 border-b border-gray-200">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Class Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Class Name *
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $class->name ?? '') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                placeholder="e.g., Mathematics 101" required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Class Code -->
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                Class Code *
            </label>
            <input type="text" name="code" id="code" value="{{ old('code', $class->code ?? '') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                placeholder="e.g., MATH-101" required {{ isset($class) ? 'readonly' : '' }}>
            @error('code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @if (isset($class))
                <p class="mt-1 text-sm text-gray-500">Class code cannot be changed once created</p>
            @endif
        </div>

        <!-- Grade Level -->
        <div>
            <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
                Grade Level *
            </label>
            <select name="grade_level" id="grade_level"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('grade_level') border-red-500 @enderror"
                required>
                <option value="">Select Grade Level</option>
                @foreach (['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $level)
                    <option value="{{ $level }}"
                        {{ old('grade_level', $class->grade_level ?? '') == $level ? 'selected' : '' }}>
                        {{ $level }}
                    </option>
                @endforeach
            </select>
            @error('grade_level')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Section -->
        <div>
            <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                Section *
            </label>
            <input type="text" name="section" id="section" value="{{ old('section', $class->section ?? '') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('section') border-red-500 @enderror"
                placeholder="e.g., A, B, C" required>
            @error('section')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<!-- Class Details Section -->
<div class="p-6 border-b border-gray-200">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Class Details</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Subject -->
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                Subject
            </label>
            <input type="text" name="subject" id="subject" value="{{ old('subject', $class->subject ?? '') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                placeholder="e.g., Mathematics">
            @error('subject')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Room Number -->
        <div>
            <label for="room_number" class="block text-sm font-medium text-gray-700 mb-2">
                Room Number
            </label>
            <input type="text" name="room_number" id="room_number"
                value="{{ old('room_number', $class->room_number ?? '') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('room_number') border-red-500 @enderror"
                placeholder="e.g., Room 101">
            @error('room_number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Academic Year -->
        <div>
            <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
                Academic Year *
            </label>
            <input type="text" name="academic_year" id="academic_year"
                value="{{ old('academic_year', $class->academic_year ?? date('Y') . '-' . (date('Y') + 1)) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('academic_year') border-red-500 @enderror"
                placeholder="e.g., 2024-2025" required pattern="\d{4}-\d{4}">
            @error('academic_year')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Capacity -->
        <div>
            <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                Maximum Capacity *
            </label>
            <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $class->capacity ?? 30) }}"
                min="1" max="100"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('capacity') border-red-500 @enderror"
                required>
            @error('capacity')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @if (isset($class) && $class->enrolled_count > 0)
                <p
                    class="mt-1 text-sm {{ $class->enrolled_count > $class->capacity ? 'text-red-600' : 'text-gray-600' }}">
                    Currently enrolled: {{ $class->enrolled_count }} students
                </p>
            @endif
        </div>
    </div>
</div>

<!-- Schedule & Additional Information -->
<div class="p-6 border-b border-gray-200">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Schedule & Additional Information</h2>

    <div class="grid grid-cols-1 gap-6">
        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Class Description
            </label>
            <textarea name="description" id="description" rows="4"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                placeholder="Enter class description...">{{ old('description', $class->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Schedule Information -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Start Time -->
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                    Start Time
                </label>
                <input type="time" name="start_time" id="start_time"
                    value="{{ old('start_time', $class->start_time ? \Carbon\Carbon::parse($class->start_time)->format('H:i') : '') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- End Time -->
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                    End Time
                </label>
                <input type="time" name="end_time" id="end_time"
                    value="{{ old('end_time', $class->end_time ? \Carbon\Carbon::parse($class->end_time)->format('H:i') : '') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Days of Week -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Meeting Days
                </label>
                <div class="flex flex-wrap gap-2">
                    @php
                        $meetingDays =
                            isset($class) && $class->meeting_days
                                ? explode(',', $class->meeting_days)
                                : old('meeting_days', []);
                    @endphp
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="meeting_days[]" value="{{ $day }}"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                {{ in_array($day, $meetingDays) ? 'checked' : '' }}>
                            <span class="ml-1 text-sm text-gray-700">{{ substr($day, 0, 3) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status & Teacher Assignment -->
<div class="p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Status & Teacher Assignment</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                Status *
            </label>
            <select name="status" id="status"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required>
                <option value="active" {{ old('status', $class->status ?? '') == 'active' ? 'selected' : '' }}>
                    Active</option>
                <option value="inactive" {{ old('status', $class->status ?? '') == 'inactive' ? 'selected' : '' }}>
                    Inactive</option>
                <option value="planned" {{ old('status', $class->status ?? '') == 'planned' ? 'selected' : '' }}>
                    Planned</option>
            </select>
        </div>

        <!-- Teacher Assignment -->
        <div>
            <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                Assign Teacher
            </label>
            <select name="teacher_id" id="teacher_id"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select a Teacher</option>
                @if (isset($teachers) && $teachers->count())
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ old('teacher_id', $class->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }} - {{ $teacher->email }}
                            @if ($teacher->class_id && (!isset($class) || $teacher->class_id != $class->id))
                                (Currently assigned to another class)
                            @endif
                        </option>
                    @endforeach
                @endif
            </select>
            <p class="mt-1 text-sm text-gray-500">You can assign a teacher later if needed</p>
        </div>
    </div>
</div>
