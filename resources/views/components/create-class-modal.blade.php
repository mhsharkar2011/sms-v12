<div x-data="classModal()" x-cloak>
    <!-- Trigger Button -->
    <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
        <span class="material-icons-sharp text-sm">add</span>
        <span>Create New Class</span>
    </button>

    <!-- Modal Backdrop -->
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         @click="open = false">

        <!-- Modal Content -->
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden"
             @click.stop>

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Create New Class</h2>
                    <p class="text-gray-600 mt-1">Add a new class to the system</p>
                </div>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-icons-sharp">close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form method="POST" action="{{ route('admin.classes.store') }}" class="overflow-y-auto max-h-[60vh]">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Class Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Class Name *
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       required
                                       x-model="formData.name"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="e.g., Class 10-A">
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Class Code -->
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Class Code *
                                </label>
                                <input type="text"
                                       id="code"
                                       name="code"
                                       required
                                       x-model="formData.code"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="e.g., C10A">
                                @error('code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Grade and Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grade & Section</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Grade Level -->
                            <div>
                                <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
                                    Grade Level *
                                </label>
                                <select id="grade_level"
                                        name="grade_level"
                                        required
                                        x-model="formData.grade_level"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Grade Level</option>
                                    <option value="Nursery">Nursery</option>
                                    <option value="LKG">LKG</option>
                                    <option value="UKG">UKG</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">Grade {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('grade_level')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Section -->
                            <div>
                                <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                                    Section *
                                </label>
                                <select id="section"
                                        name="section"
                                        required
                                        x-model="formData.section"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Section</option>
                                    <option value="A">Section A</option>
                                    <option value="B">Section B</option>
                                    <option value="C">Section C</option>
                                    <option value="D">Section D</option>
                                </select>
                                @error('section')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Class Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Class Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Capacity -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                    Capacity *
                                </label>
                                <input type="number"
                                       id="capacity"
                                       name="capacity"
                                       required
                                       min="1"
                                       max="60"
                                       x-model="formData.capacity"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="e.g., 40">
                                @error('capacity')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Room Number -->
                            <div>
                                <label for="room_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Room Number
                                </label>
                                <input type="text"
                                       id="room_number"
                                       name="room_number"
                                       x-model="formData.room_number"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="e.g., R201">
                                @error('room_number')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Class Teacher -->
                    <div>
                        <label for="class_teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Class Teacher
                        </label>
                        <select id="class_teacher_id"
                                name="class_teacher_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Class Teacher (Optional)</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }} - {{ $teacher->email }}</option>
                            @endforeach
                        </select>
                        @error('class_teacher_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="3"
                                  x-model="formData.description"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Optional class description..."></textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="status"
                                   value="active"
                                   x-model="formData.status"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2"
                                   checked>
                            <span class="text-sm font-medium text-gray-700">Set as active class</span>
                        </label>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50">
                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <span class="material-icons-sharp text-sm">check</span>
                        <span>Create Class</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function classModal() {
        return {
            open: false,
            formData: {
                name: '',
                code: '',
                grade_level: '',
                section: '',
                capacity: 40,
                room_number: '',
                description: '',
                status: true
            },
            init() {
                // Auto-generate class code when name, grade, or section changes
                this.$watch('formData', (value) => {
                    if (value.grade_level && value.section) {
                        this.generateClassCode();
                    }
                }, { deep: true });
            },
            generateClassCode() {
                const grade = this.formData.grade_level;
                const section = this.formData.section;

                if (grade && section) {
                    let gradeCode = '';

                    // Convert grade level to code
                    if (grade === 'Nursery') gradeCode = 'NUR';
                    else if (grade === 'LKG') gradeCode = 'LKG';
                    else if (grade === 'UKG') gradeCode = 'UKG';
                    else gradeCode = 'C' + grade;

                    this.formData.code = gradeCode + section;

                    // Also generate name if not set
                    if (!this.formData.name) {
                        if (['Nursery', 'LKG', 'UKG'].includes(grade)) {
                            this.formData.name = `${grade} - Section ${section}`;
                        } else {
                            this.formData.name = `Class ${grade} - Section ${section}`;
                        }
                    }
                }
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
