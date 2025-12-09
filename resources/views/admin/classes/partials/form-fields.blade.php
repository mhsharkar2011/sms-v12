{{-- resources/views/admin/classes/partials/form-fields.blade.php --}}
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
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->user->name }}"
                    {{ old('teacher_id', isset($class) && is_object($class) ? $class->name : '') == $teacher->user->user_id ? 'selected' : '' }}>
                    {{ $teacher->user->name }} ({{ $teacher->user->email }})
                </option>
            @endforeach
        </select>
        @error('teacher_id')
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
                    <input type="checkbox" name="schedule_days[]" value="{{ $day }}"
                        @php
                            $scheduleDays = old('schedule_days', []);
                            if (isset($class) && is_object($class) && $class->schedule_days) {
                                $scheduleDays = json_decode($class->schedule_days, true) ?? [];
                            }
                        @endphp
                        {{ in_array($day, $scheduleDays) ? 'checked' : '' }}
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

    <!-- Status -->
    <div class="flex items-center space-x-3">
        <input type="checkbox" name="is_active" id="is_active" value="1"
            {{ old('is_active', isset($class) && is_object($class) ? $class->is_active : true) ? 'checked' : '' }}
            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <label for="is_active" class="text-sm font-medium text-gray-700">
            Active Class
        </label>
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
