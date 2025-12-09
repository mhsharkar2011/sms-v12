<!-- resources/views/admin/classes/modals/assign-students.blade.php -->
<div id="assignStudentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Assign Students</h2>
                <p class="text-gray-600 mt-1" id="modalClassName">Class Name</p>
            </div>
            <button onclick="closeStudentModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-icons-sharp">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <!-- Search and Filters -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Students</label>
                        <div class="relative">
                            <input type="text" id="studentSearchInput" onkeyup="filterStudents()"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Search by name, ID, or email...">
                            <span
                                class="material-icons-sharp absolute left-3 top-2.5 text-gray-400 text-sm">search</span>
                        </div>
                    </div>

                    <!-- Grade Filter (Optional) -->
                    <div class="md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                        <select id="gradeFilter" onchange="filterStudents()"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Grades</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                    </div>
                </div>

                <!-- Selected Count -->
                <div class="flex items-center justify-between">
                    <div>
                        <span id="selectedCount" class="text-sm text-gray-600">0 students selected</span>
                        <span id="classCapacity" class="text-sm text-gray-400 ml-2"></span>
                    </div>
                    <div>
                        <button onclick="selectAllStudents()"
                            class="text-sm text-blue-600 hover:text-blue-800 mr-4">Select All</button>
                        <button onclick="deselectAllStudents()"
                            class="text-sm text-gray-600 hover:text-gray-800">Deselect All</button>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="text-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                <p class="text-gray-600 mt-4">Loading students...</p>
            </div>

            <!-- Error State -->
            <div id="errorState" class="hidden text-center py-8">
                <div class="text-red-500 mb-4">
                    <span class="material-icons-sharp text-4xl">error</span>
                </div>
                <p class="text-red-600 font-medium mb-2" id="errorMessage">Failed to load students</p>
                <div class="text-sm text-gray-600 mb-4" id="errorDetails"></div>
                <button onclick="retryLoading()"
                    class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                    Retry
                </button>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-8">
                <div class="text-gray-400 mb-4">
                    <span class="material-icons-sharp text-4xl">person_off</span>
                </div>
                <p class="text-gray-600 font-medium mb-2">No students found</p>
                <p class="text-gray-500 text-sm">Try adjusting your search or filters</p>
            </div>

            <!-- Students List -->
            <div id="studentsListContainer" class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg hidden">
                <div class="divide-y divide-gray-200" id="studentsList">
                    <!-- Students will be loaded here dynamically -->
                </div>
            </div>

            <!-- Bulk Actions -->
            <div id="bulkActions" class="hidden mt-4 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <span id="bulkSelectedCount" class="text-sm font-medium text-gray-700"></span>
                    <div class="flex space-x-2">
                        <button onclick="assignSelectedStudents()"
                            class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                            Assign Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-between p-6 border-t border-gray-200 bg-gray-50">
            <div class="text-sm text-gray-600">
                <span id="totalStudentsCount">0</span> students total
            </div>
            <div class="flex space-x-3">
                <button onclick="closeStudentModal()"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="saveStudentAssignments()" id="saveButton"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-icons-sharp text-sm">save</span>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Notification -->
<div id="successNotification"
    class="fixed top-4 right-4 p-4 bg-green-500 text-white rounded-lg shadow-lg z-[60] hidden animate-slide-in">
    <div class="flex items-center space-x-3">
        <span class="material-icons-sharp">check_circle</span>
        <span id="successMessage">Students assigned successfully!</span>
    </div>
</div>

<!-- Error Notification -->
<div id="errorNotification"
    class="fixed top-4 right-4 p-4 bg-red-500 text-white rounded-lg shadow-lg z-[60] hidden animate-slide-in">
    <div class="flex items-center space-x-3">
        <span class="material-icons-sharp">error</span>
        <span id="errorNotificationMessage">Failed to assign students</span>
    </div>
</div>

<style>
    .student-item {
        transition: all 0.2s ease;
    }

    .student-item:hover {
        background-color: #f9fafb;
    }

    .student-item.selected {
        background-color: #eff6ff;
        border-color: #3b82f6;
    }

    .student-avatar {
        transition: transform 0.2s ease;
    }

    .student-item:hover .student-avatar {
        transform: scale(1.05);
    }

    .checkbox-wrapper input:checked~.checkmark {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    .checkbox-wrapper input:checked~.checkmark::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
</style>

<script>
    // Modal state
    let currentClassId = null;
    let currentClassName = null;
    let allStudents = [];
    let assignedStudents = [];
    let selectedStudents = new Set();
    let currentClassCapacity = null;

    // Open modal
    window.openAssignStudentModal = function(classId, className) {
        currentClassId = classId;
        currentClassName = className;

        // Update modal title
        document.getElementById('modalClassName').textContent = className;

        // Reset selections
        selectedStudents.clear();
        updateSelectionCount();

        // Show modal
        const modal = document.getElementById('assignStudentModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Load students
        loadStudentsForAssignment(classId);
    }

    // Close modal
    window.closeStudentModal = function() {
        const modal = document.getElementById('assignStudentModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Reset state
        currentClassId = null;
        currentClassName = null;
        allStudents = [];
        assignedStudents = [];
        selectedStudents.clear();
    }

    // Load students with better error handling
    async function loadStudentsForAssignment(classId) {
        showLoading(true);
        showError(false);
        showEmptyState(false);

        try {
            console.log(`Loading students for class ${classId}...`);

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Create headers
            const headers = {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }

            // Fetch students data
            const response = await fetch(`/admin/classes/${classId}/students`, {
                headers: headers,
                credentials: 'same-origin' // Include cookies for authentication
            });

            console.log('Response status:', response.status);
            console.log('Response URL:', response.url);

            // Get response text first to check content type
            const responseText = await response.text();
            console.log('Response preview:', responseText.substring(0, 200));

            // Check if response is HTML (error page)
            if (responseText.trim().startsWith('<!DOCTYPE') ||
                responseText.trim().startsWith('<html') ||
                responseText.includes('<!DOCTYPE html>')) {

                console.error('Server returned HTML instead of JSON');

                // Check for common error pages
                let errorMessage = 'Server returned HTML page. This could mean:';
                if (responseText.includes('404')) {
                    errorMessage += '\n• Route not found';
                }
                if (responseText.includes('login') || responseText.includes('Sign In')) {
                    errorMessage += '\n• Authentication required (not logged in)';
                }
                if (responseText.includes('CSRF')) {
                    errorMessage += '\n• CSRF token mismatch';
                }

                throw new Error(errorMessage);
            }

            // Try to parse as JSON
            let data;
            try {
                data = JSON.parse(responseText);
            } catch (jsonError) {
                console.error('Failed to parse JSON:', jsonError);
                console.error('Raw response:', responseText);
                throw new Error('Invalid JSON response from server');
            }

            console.log('Parsed data:', data);

            if (!response.ok) {
                throw new Error(data.message || `HTTP error ${response.status}: ${response.statusText}`);
            }

            if (!data.success) {
                throw new Error(data.message || 'Failed to load students');
            }

            // Store data
            allStudents = data.students || [];
            assignedStudents = data.assignedStudents || [];
            currentClassCapacity = data.capacity || 40;

            // Update capacity display
            document.getElementById('classCapacity').textContent = `(Capacity: ${currentClassCapacity})`;

            // Render students
            renderStudentsList();

            // Update counts
            updateTotalCount();
            updateSelectionCount();

        } catch (error) {
            console.error('Error loading students:', error);

            // Show error with details
            document.getElementById('errorMessage').textContent = 'Failed to load students';
            document.getElementById('errorDetails').innerHTML = `
                <div class="text-left">
                    <p class="mb-2">${error.message}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Check:
                        <ul class="mt-1 space-y-1">
                            <li>• Is the route defined? (/admin/classes/{id}/students)</li>
                            <li>• Are you logged in?</li>
                            <li>• Check browser console for details</li>
                        </ul>
                    </p>
                </div>
            `;
            showError(true);

            // Fallback to mock data for testing
            setTimeout(() => {
                useMockData();
            }, 1000);

        } finally {
            showLoading(false);
        }
    }

    // Use mock data as fallback
    function useMockData() {
        console.log('Using mock data as fallback');

        // Mock data for testing
        const mockData = {
            students: [{
                    id: 1,
                    first_name: 'John',
                    last_name: 'Doe',
                    email: 'john@example.com',
                    student_id: 'S001',
                    grade_level: '10'
                },
                {
                    id: 2,
                    first_name: 'Jane',
                    last_name: 'Smith',
                    email: 'jane@example.com',
                    student_id: 'S002',
                    grade_level: '10'
                },
                {
                    id: 3,
                    first_name: 'Bob',
                    last_name: 'Johnson',
                    email: 'bob@example.com',
                    student_id: 'S003',
                    grade_level: '11'
                },
                {
                    id: 4,
                    first_name: 'Alice',
                    last_name: 'Williams',
                    email: 'alice@example.com',
                    student_id: 'S004',
                    grade_level: '12'
                }
            ],
            assignedStudents: [1, 2],
            capacity: 30
        };

        allStudents = mockData.students;
        assignedStudents = mockData.assignedStudents;
        currentClassCapacity = mockData.capacity;

        document.getElementById('classCapacity').textContent = `(Capacity: ${currentClassCapacity})`;
        document.getElementById('errorState').classList.add('hidden');
        renderStudentsList();
        updateTotalCount();
        updateSelectionCount();

        // Show info about using mock data
        showNotification('Using sample data for demonstration', 'info');
    }

    // Render students list
    function renderStudentsList() {
        const container = document.getElementById('studentsListContainer');
        const list = document.getElementById('studentsList');

        if (!allStudents.length) {
            showEmptyState(true);
            container.classList.add('hidden');
            return;
        }

        // Clear previous list
        list.innerHTML = '';

        // Create student items
        allStudents.forEach(student => {
            const isAssigned = assignedStudents.includes(student.id);
            const isSelected = selectedStudents.has(student.id);
            const fullName = `${student.first_name || ''} ${student.last_name || ''}`.trim();
            const initials = fullName.charAt(0) || '?';

            const studentItem = document.createElement('div');
            studentItem.className = `student-item p-4 ${isSelected ? 'selected' : ''}`;
            studentItem.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="student-avatar w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                            ${initials}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center space-x-2">
                                <h3 class="text-sm font-medium text-gray-900 truncate">${fullName}</h3>
                                ${isAssigned ?
                                    '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Assigned</span>' :
                                    ''
                                }
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <span class="truncate">${student.student_id || 'N/A'}</span>
                                <span class="mx-1">•</span>
                                <span class="truncate">${student.email || 'No email'}</span>
                            </div>
                            ${student.grade_level ?
                                `<div class="text-xs text-gray-400 mt-1">Grade ${student.grade_level}</div>` :
                                ''
                            }
                        </div>
                    </div>
                    <label class="checkbox-wrapper flex items-center cursor-pointer">
                        <input type="checkbox"
                               class="sr-only"
                               data-student-id="${student.id}"
                               ${isSelected ? 'checked' : ''}
                               onchange="toggleStudentSelection(${student.id}, this.checked)">
                        <div class="checkmark w-5 h-5 border border-gray-300 rounded flex items-center justify-center">
                        </div>
                    </label>
                </div>
            `;

            list.appendChild(studentItem);
        });

        container.classList.remove('hidden');
        showEmptyState(false);
    }

    // Toggle student selection
    window.toggleStudentSelection = function(studentId, isChecked) {
        if (isChecked) {
            selectedStudents.add(studentId);
        } else {
            selectedStudents.delete(studentId);
        }

        // Update UI
        updateSelectionCount();
        updateBulkActions();

        // Update item styling
        const item = document.querySelector(`[data-student-id="${studentId}"]`)?.closest('.student-item');
        if (item) {
            item.classList.toggle('selected', isChecked);
        }
    }

    // Select all students
    window.selectAllStudents = function() {
        allStudents.forEach(student => {
            selectedStudents.add(student.id);
        });

        // Update checkboxes
        document.querySelectorAll('[data-student-id]').forEach(checkbox => {
            checkbox.checked = true;
        });

        // Update UI
        updateSelectionCount();
        updateBulkActions();
        renderStudentsList(); // Re-render to update styling
    }

    // Deselect all students
    window.deselectAllStudents = function() {
        selectedStudents.clear();

        // Update checkboxes
        document.querySelectorAll('[data-student-id]').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Update UI
        updateSelectionCount();
        updateBulkActions();
        renderStudentsList(); // Re-render to update styling
    }

    // Filter students based on search and filters
    window.filterStudents = function() {
        const searchTerm = document.getElementById('studentSearchInput').value.toLowerCase();
        const gradeFilter = document.getElementById('gradeFilter').value;

        // Get all student items
        const studentItems = document.querySelectorAll('#studentsList .student-item');

        studentItems.forEach(item => {
            const studentText = item.textContent.toLowerCase();
            const gradeMatch = gradeFilter === '' ||
                (item.querySelector('.text-xs.text-gray-400')?.textContent.includes(gradeFilter) ||
                    gradeFilter === '');

            const searchMatch = searchTerm === '' || studentText.includes(searchTerm);

            item.style.display = (searchMatch && gradeMatch) ? '' : 'none';
        });
    }

    // Save assignments
    window.saveStudentAssignments = async function() {
        const saveButton = document.getElementById('saveButton');
        const originalText = saveButton.innerHTML;

        // Disable button and show loading
        saveButton.disabled = true;
        saveButton.innerHTML = `
            <span class="material-icons-sharp text-sm animate-spin">refresh</span>
            <span>Saving...</span>
        `;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const studentIds = Array.from(selectedStudents);

            // Validate capacity
            if (studentIds.length > currentClassCapacity) {
                throw new Error(
                    `Cannot assign ${studentIds.length} students. Class capacity is ${currentClassCapacity}.`
                );
            }

            // Create headers
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }

            const response = await fetch(`/admin/classes/${currentClassId}/assign-students`, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    student_ids: studentIds
                })
            });

            // Get response text first
            const responseText = await response.text();
            let data;

            try {
                data = JSON.parse(responseText);
            } catch (error) {
                console.error('Failed to parse response:', responseText);
                throw new Error('Invalid response from server');
            }

            if (!response.ok) {
                throw new Error(data.message || `HTTP error ${response.status}`);
            }

            if (data.success) {
                // Show success notification
                showNotification(data.message || 'Students assigned successfully!', 'success');

                // Close modal after delay
                setTimeout(() => {
                    closeStudentModal();

                    // Reload page to show updated data
                    setTimeout(() => location.reload(), 1000);
                }, 1500);

            } else {
                throw new Error(data.message || 'Assignment failed');
            }

        } catch (error) {
            console.error('Error saving assignments:', error);
            showNotification(`Error: ${error.message}`, 'error');
        } finally {
            // Restore button
            saveButton.disabled = false;
            saveButton.innerHTML = originalText;
        }
    }

    // Assign selected students (bulk action)
    window.assignSelectedStudents = function() {
        // Convert assigned students to selected
        assignedStudents.forEach(id => {
            selectedStudents.add(id);
        });

        // Update UI
        updateSelectionCount();
        renderStudentsList();
        showNotification('Selected students assigned to current selection', 'info');
    }

    // Update selection count
    function updateSelectionCount() {
        const count = selectedStudents.size;
        document.getElementById('selectedCount').textContent =
            `${count} ${count === 1 ? 'student' : 'students'} selected`;

        // Enable/disable save button
        const saveButton = document.getElementById('saveButton');
        saveButton.disabled = count === 0;
    }

    // Update total count
    function updateTotalCount() {
        document.getElementById('totalStudentsCount').textContent = allStudents.length;
    }

    // Update bulk actions
    function updateBulkActions() {
        const bulkActions = document.getElementById('bulkActions');
        const bulkSelectedCount = document.getElementById('bulkSelectedCount');

        if (selectedStudents.size > 0) {
            bulkSelectedCount.textContent = `${selectedStudents.size} selected`;
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    // Show/hide loading state
    function showLoading(show) {
        document.getElementById('loadingState').style.display = show ? 'block' : 'none';
    }

    // Show/hide error state
    function showError(show) {
        const errorState = document.getElementById('errorState');
        if (show) {
            errorState.classList.remove('hidden');
        } else {
            errorState.classList.add('hidden');
        }
    }

    // Show/hide empty state
    function showEmptyState(show) {
        document.getElementById('emptyState').style.display = show ? 'block' : 'none';
    }

    // Retry loading
    window.retryLoading = function() {
        if (currentClassId) {
            loadStudentsForAssignment(currentClassId);
        }
    }

    // Show notification
    function showNotification(message, type = 'success') {
        const notification = type === 'success' ?
            document.getElementById('successNotification') :
            document.getElementById('errorNotification');

        const messageElement = type === 'success' ?
            document.getElementById('successMessage') :
            document.getElementById('errorNotificationMessage');

        messageElement.textContent = message;

        // Show notification
        notification.classList.remove('hidden');

        // Hide after 3 seconds
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('assignStudentModal');

        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeStudentModal();
                }
            });

            // Close with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeStudentModal();
                }
            });
        }

        // Initialize mock data on page load for testing
        console.log('Student assignment modal loaded');
        console.log('Note: If API endpoints are not configured, mock data will be used.');
    });
</script>
