<div id="bulkAssignModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Bulk Student Assignment</h2>
                <p class="text-gray-600 mt-1" id="bulkModalTitle">Assign students to multiple classes</p>
            </div>
            <button onclick="closeBulkAssignModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-icons-sharp">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
            <!-- Step 1: Select Classes -->
            <div id="step1" class="space-y-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="material-icons-sharp text-blue-600 mr-3">info</span>
                        <div>
                            <h3 class="font-medium text-blue-900">How it works</h3>
                            <p class="text-sm text-blue-700 mt-1">
                                You can assign the same set of students to multiple classes at once.
                                This is useful for cross-class activities or shared courses.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Source Class -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Copy Students From</label>
                        <select id="sourceClass" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">Select a class to copy from</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->current_strength }}
                                    students)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Target Classes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign to Classes</label>
                        <select id="targetClasses" multiple
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32">
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}
                                    ({{ $class->current_strength }}/{{ $class->capacity }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Operation Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assignment Type</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label
                            class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="operation" value="add" checked class="mr-3">
                            <div>
                                <div class="font-medium text-gray-900">Add Students</div>
                                <div class="text-sm text-gray-500 mt-1">Add selected students to target classes</div>
                            </div>
                        </label>
                        <label
                            class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="operation" value="replace" class="mr-3">
                            <div>
                                <div class="font-medium text-gray-900">Replace All</div>
                                <div class="text-sm text-gray-500 mt-1">Replace all students in target classes</div>
                            </div>
                        </label>
                        <label
                            class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="operation" value="remove" class="mr-3">
                            <div>
                                <div class="font-medium text-gray-900">Remove Students</div>
                                <div class="text-sm text-gray-500 mt-1">Remove selected students from target classes
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Step 2: Select Students -->
            <div id="step2" class="hidden space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Select Students to Assign</h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="selectAllBulkStudents()" class="text-sm text-blue-600 hover:text-blue-800">
                            Select All
                        </button>
                        <button onclick="deselectAllBulkStudents()" class="text-sm text-gray-600 hover:text-gray-800">
                            Deselect All
                        </button>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div id="bulkStudentsList" class="max-h-64 overflow-y-auto">
                        <!-- Students will be loaded here -->
                    </div>
                </div>

                <!-- Summary -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-blue-900" id="selectedStudentsCount">0</div>
                            <div class="text-sm text-blue-700">Students Selected</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-blue-900" id="targetClassesCount">0</div>
                            <div class="text-sm text-blue-700">Target Classes</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-blue-900" id="totalAssignments">0</div>
                            <div class="text-sm text-blue-700">Total Assignments</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-between p-6 border-t border-gray-200 bg-gray-50">
            <div>
                <button onclick="prevStep()" id="prevBtn"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors hidden">
                    Previous
                </button>
            </div>
            <div class="flex space-x-3">
                <button onclick="closeBulkAssignModal()"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="nextStep()" id="nextBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Next
                </button>
                <button onclick="processBulkAssignment()" id="processBtn"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors hidden">
                    Process Assignment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    let bulkSelectedStudents = new Set();
    let bulkTargetClasses = [];

    function openBulkAssignModal(selectedClassIds = []) {
        const modal = document.getElementById('bulkAssignModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Pre-select classes if provided
        if (selectedClassIds.length > 0) {
            const targetSelect = document.getElementById('targetClasses');
            Array.from(targetSelect.options).forEach(option => {
                option.selected = selectedClassIds.includes(parseInt(option.value));
            });
            updateTargetClassesCount();
        }

        // Reset steps
        currentStep = 1;
        showStep(currentStep);
    }

    function closeBulkAssignModal() {
        const modal = document.getElementById('bulkAssignModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetBulkModal();
    }

    function showStep(step) {
        // Hide all steps
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.add('hidden');

        // Show current step
        document.getElementById('step' + step).classList.remove('hidden');

        // Update buttons
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const processBtn = document.getElementById('processBtn');

        if (step === 1) {
            prevBtn.classList.add('hidden');
            nextBtn.classList.remove('hidden');
            processBtn.classList.add('hidden');
            nextBtn.textContent = 'Next';
        } else if (step === 2) {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.add('hidden');
            processBtn.classList.remove('hidden');
            loadBulkStudents();
        }
    }

    function nextStep() {
        if (currentStep === 1) {
            // Validate step 1
            const sourceClass = document.getElementById('sourceClass').value;
            const targetClasses = Array.from(document.getElementById('targetClasses').selectedOptions).map(opt => opt
                .value);

            if (!sourceClass || targetClasses.length === 0) {
                alert('Please select both source and target classes');
                return;
            }

            bulkTargetClasses = targetClasses;
            currentStep = 2;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    async function loadBulkStudents() {
        const sourceClassId = document.getElementById('sourceClass').value;
        if (!sourceClassId) return;

        const studentsList = document.getElementById('bulkStudentsList');
        studentsList.innerHTML = `
            <div class="text-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                <p class="text-gray-500 mt-2">Loading students...</p>
            </div>
        `;

        try {
            const response = await fetch(`/admin/classes/${sourceClassId}/students`);
            const data = await response.json();

            if (data.success) {
                renderBulkStudentsList(data.students);
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            studentsList.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-500">Error loading students: ${error.message}</p>
                </div>
            `;
        }
    }

    function renderBulkStudentsList(students) {
        const container = document.getElementById('bulkStudentsList');
        if (!students || students.length === 0) {
            container.innerHTML = '<div class="text-center py-8 text-gray-500">No students found</div>';
            return;
        }

        let html = '<div class="space-y-2">';
        students.forEach(student => {
            const fullName = `${student.first_name || ''} ${student.last_name || ''}`.trim();
            const isSelected = bulkSelectedStudents.has(student.id);

            html += `
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox"
                           value="${student.id}"
                           ${isSelected ? 'checked' : ''}
                           onchange="toggleBulkStudent(${student.id}, this.checked)"
                           class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                            ${fullName.charAt(0) || '?'}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate">${fullName}</div>
                            <div class="text-xs text-gray-500 truncate">${student.student_id || ''} • ${student.email || ''}</div>
                        </div>
                    </div>
                </label>
            `;
        });
        html += '</div>';

        container.innerHTML = html;
        updateBulkSelectionCounts();
    }

    function toggleBulkStudent(studentId, isSelected) {
        if (isSelected) {
            bulkSelectedStudents.add(studentId);
        } else {
            bulkSelectedStudents.delete(studentId);
        }
        updateBulkSelectionCounts();
    }

    function selectAllBulkStudents() {
        const checkboxes = document.querySelectorAll('#bulkStudentsList input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
            bulkSelectedStudents.add(parseInt(checkbox.value));
        });
        updateBulkSelectionCounts();
    }

    function deselectAllBulkStudents() {
        const checkboxes = document.querySelectorAll('#bulkStudentsList input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        bulkSelectedStudents.clear();
        updateBulkSelectionCounts();
    }

    function updateBulkSelectionCounts() {
        const selectedCount = bulkSelectedStudents.size;
        const targetCount = bulkTargetClasses.length;
        const totalAssignments = selectedCount * targetCount;

        document.getElementById('selectedStudentsCount').textContent = selectedCount;
        document.getElementById('targetClassesCount').textContent = targetCount;
        document.getElementById('totalAssignments').textContent = totalAssignments;
    }

    function updateTargetClassesCount() {
        const targetClasses = Array.from(document.getElementById('targetClasses').selectedOptions);
        document.getElementById('targetClassesCount').textContent = targetClasses.length;
    }

    async function processBulkAssignment() {
        const sourceClassId = document.getElementById('sourceClass').value;
        const operation = document.querySelector('input[name="operation"]:checked').value;
        const studentIds = Array.from(bulkSelectedStudents);

        if (studentIds.length === 0 || bulkTargetClasses.length === 0) {
            alert('Please select students and target classes');
            return;
        }

        const processBtn = document.getElementById('processBtn');
        const originalText = processBtn.innerHTML;
        processBtn.innerHTML = '<span class="animate-spin">⏳</span> Processing...';
        processBtn.disabled = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/admin/classes/bulk-assign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    source_class_id: sourceClassId,
                    target_class_ids: bulkTargetClasses,
                    student_ids: studentIds,
                    operation: operation
                })
            });

            const data = await response.json();

            if (data.success) {
                alert(`Successfully assigned ${studentIds.length} students to ${bulkTargetClasses.length} classes`);
                closeBulkAssignModal();
                // Optionally reload the page
                location.reload();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            alert('Error: ' + error.message);
        } finally {
            processBtn.innerHTML = originalText;
            processBtn.disabled = false;
        }
    }

    function resetBulkModal() {
        currentStep = 1;
        bulkSelectedStudents.clear();
        bulkTargetClasses = [];
        document.getElementById('sourceClass').value = '';
        document.getElementById('targetClasses').selectedIndex = -1;
        showStep(currentStep);
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('bulkAssignModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeBulkAssignModal();
                }
            });

            document.getElementById('sourceClass').addEventListener('change', loadBulkStudents);
            document.getElementById('targetClasses').addEventListener('change', updateTargetClassesCount);
        }

        // Make function globally available
        window.openBulkAssignModal = openBulkAssignModal;
    });
</script>
