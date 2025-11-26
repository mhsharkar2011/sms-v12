<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Subjects Taught</h3>

    @foreach($subjects as $subject)
        <div class="flex items-center justify-between p-3 border-b">
            <div>
                <span class="font-medium">{{ $subject->subject_name }}</span>
                <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $subject->proficiency_badge_class }}">
                    {{ $subject->formatted_proficiency }}
                </span>
                @if($subject->is_primary)
                    <span class="ml-2 px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">Primary</span>
                @endif
            </div>
            <div class="text-sm text-gray-500">
                {{ $subject->years_of_experience }} years experience
            </div>
        </div>
    @endforeach

    @if($subjects->isEmpty())
        <p class="text-gray-500 text-center py-4">No subjects assigned yet.</p>
    @endif
</div>
