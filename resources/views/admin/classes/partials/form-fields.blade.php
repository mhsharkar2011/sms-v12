{{-- resources/views/admin/classes/partials/form-fields.blade.php --}}

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Class Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Class Name *
        </label>
        <input type="text" name="name" id="name"
            value="{{ old('name', isset($class) && is_object($class) ? $class->name : '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
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
        <input type="text" name="code" id="code"
            value="{{ old('code', isset($class) && is_object($class) ? $class->code : '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror"
            placeholder="e.g., MATH-101-A" required>
        @error('code')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Grade Level -->
    <div>
        <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
            Grade Level *
        </label>
        <select name="grade_level" id="grade_level"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('grade_level') border-red-500 @enderror"
            required>
            <option value="">Select Grade Level</option>
            @foreach (['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $level)
                <option value="{{ $level }}"
                    {{ old('grade_level', isset($class) && is_object($class) ? $class->grade_level : '') == $level ? 'selected' : '' }}>
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
        <input type="text" name="section" id="section"
            value="{{ old('section', isset($class) && is_object($class) ? $class->section : '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('section') border-red-500 @enderror"
            placeholder="e.g., A, B, C" required>
        @error('section')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Subject -->
    <div>
        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
            Subject
        </label>
        <input type="text" name="subject" id="subject"
            value="{{ old('subject', isset($class) && is_object($class) ? $class->subject : '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror"
            placeholder="e.g., Mathematics">
        @error('subject')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Teacher -->
    <div>
        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
            Class Teacher
        </label>
        <select name="teacher_id" id="teacher_id"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('teacher_id') border-red-500 @enderror">
            <option value="">No Teacher Assigned</option>
            @if (isset($teachers) && $teachers->count() > 0)
                @foreach ($teachers as $teacher)
                    @php
                        // Determine how to access teacher data based on your structure
                        $teacherId = $teacher->id ?? ($teacher->user_id ?? null);
                        $teacherName =
                            $teacher->user->name ??
                            ($teacher->name ?? $teacher->first_name . ' ' . $teacher->last_name);
                        $teacherEmail = $teacher->user->email ?? ($teacher->email ?? '');
                    @endphp
                    @if ($teacherId)
                        <option value="{{ $teacherId }}"
                            {{ old('teacher_id', isset($class) && is_object($class) ? $class->teacher_id : '') == $teacherId ? 'selected' : '' }}>
                            {{ $teacherName }} @if ($teacherEmail)
                                ({{ $teacherEmail }})
                            @endif
                        </option>
                    @endif
                @endforeach
            @endif
        </select>
        @error('teacher_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
            Status *
        </label>
        <select name="status" id="status"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
            required>
            <option value="">Select Status</option>
            <option value="active"
                {{ old('status', isset($class) && is_object($class) ? $class->status : 'active') == 'active' ? 'selected' : '' }}>
                Active</option>
            <option value="inactive"
                {{ old('status', isset($class) && is_object($class) ? $class->status : '') == 'inactive' ? 'selected' : '' }}>
                Inactive</option>
            <option value="completed"
                {{ old('status', isset($class) && is_object($class) ? $class->status : '') == 'completed' ? 'selected' : '' }}>
                Completed</option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Academic Year -->
    <div>
        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
            Academic Year *
        </label>
        <input type="text" name="academic_year" id="academic_year"
            value="{{ old('academic_year', isset($class) && is_object($class) ? $class->academic_year : date('Y') . '-' . (date('Y') + 1)) }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('academic_year') border-red-500 @enderror"
            placeholder="e.g., 2024-2025" required>
        @error('academic_year')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Schedule Days -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Schedule Days *
        </label>
        <div class="flex flex-wrap gap-2">
            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="schedule_days[]" value="{{ strtolower($day) }}"
                        @php
$scheduleDays = old('schedule_days', []);
                            if (isset($class) && is_object($class) && $class->schedule_days) {
                                $scheduleDays = json_decode($class->schedule_days, true) ?? [];
                            } @endphp
                        {{ in_array(strtolower($day), $scheduleDays) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">{{ $day }}</span>
                </label>
            @endforeach
        </div>
        @error('schedule_days')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Schedule Times -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                Start Time
            </label>
            <input type="time" name="start_time" id="start_time"
                value="{{ old('start_time', isset($class) && is_object($class) && $class->start_time ? \Carbon\Carbon::parse($class->start_time)->format('H:i') : '') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('start_time') border-red-500 @enderror">
            @error('start_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                End Time
            </label>
            <input type="time" name="end_time" id="end_time"
                value="{{ old('end_time', isset($class) && is_object($class) && $class->end_time ? \Carbon\Carbon::parse($class->end_time)->format('H:i') : '') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('end_time') border-red-500 @enderror">
            @error('end_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Room Number -->
    <div>
        <label for="room_number" class="block text-sm font-medium text-gray-700 mb-2">
            Room Number
        </label>
        <input type="text" name="room_number" id="room_number"
            value="{{ old('room_number', isset($class) && is_object($class) ? $class->room_number : '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('room_number') border-red-500 @enderror"
            placeholder="e.g., Room 101">
        @error('room_number')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Capacity -->
    <div>
        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
            Capacity
        </label>
        <input type="number" name="capacity" id="capacity"
            value="{{ old('capacity', isset($class) && is_object($class) ? $class->capacity : 30) }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('capacity') border-red-500 @enderror"
            min="1" max="100" placeholder="Maximum students">
        @error('capacity')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>

<!-- Description -->
<div class="mt-6">
    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
        Description
    </label>
    <textarea name="description" id="description" rows="3"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
        placeholder="Optional class description...">{{ old('description', isset($class) && is_object($class) ? $class->description : '') }}</textarea>
    @error('description')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
