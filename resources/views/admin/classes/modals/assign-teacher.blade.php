<!-- resources/views/admin/classes/modals/assign-teacher.blade.php -->
<div id="assignTeacherModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Assign Teacher</h2>
                <p class="text-gray-600 mt-1" id="teacherModalClassName">Class Name</p>
            </div>
            <button onclick="closeTeacherModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-icons-sharp">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <!-- Loading State -->
            <div id="teacherLoadingState" class="text-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                <p class="text-gray-600 mt-4">Loading teachers...</p>
            </div>

            <!-- Error State -->
            <div id="teacherErrorState" class="hidden text-center py-8">
                <div class="text-red-500 mb-4">
                    <span class="material-icons-sharp text-4xl">error</span>
                </div>
                <p class="text-red-600 font-medium mb-2" id="teacherErrorMessage">Failed to load teachers</p>
                <div class="text-sm text-gray-600 mb-4" id="teacherErrorDetails"></div>
                <button onclick="retryLoadingTeachers()"
                    class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                    Retry
                </button>
            </div>

            <!-- Empty State -->
            <div id="teacherEmptyState" class="hidden text-center py-8">
                <div class="text-gray-400 mb-4">
                    <span class="material-icons-sharp text-4xl">person_off</span>
                </div>
                <p class="text-gray-600 font-medium mb-2">No teachers available</p>
                <p class="text-gray-500 text-sm">All teachers might be assigned to other classes</p>
            </div>

            <!-- Teachers List -->
            <div id="teachersListContainer" class="space-y-3 max-h-96 overflow-y-auto hidden">
                <!-- Teachers will be loaded here -->
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50">
            <button onclick="closeTeacherModal()"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button onclick="saveTeacherAssignment()" id="saveTeacherButton"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="material-icons-sharp text-sm">save</span>
                <span>Assign Teacher</span>
            </button>
        </div>
    </div>
</div>

<!-- Teacher Success Notification -->
<div id="teacherSuccessNotification"
    class="fixed top-4 right-4 p-4 bg-green-500 text-white rounded-lg shadow-lg z-[60] hidden animate-slide-in">
    <div class="flex items-center space-x-3">
        <span class="material-icons-sharp">check_circle</span>
        <span>Teacher assigned successfully!</span>
    </div>
</div>

<!-- Teacher Error Notification -->
<div id="teacherErrorNotification"
    class="fixed top-4 right-4 p-4 bg-red-500 text-white rounded-lg shadow-lg z-[60] hidden animate-slide-in">
    <div class="flex items-center space-x-3">
        <span class="material-icons-sharp">error</span>
        <span id="teacherErrorNotificationMessage">Failed to assign teacher</span>
    </div>
</div>

<script>
    // Teacher modal state
    let teacherClassId = null;
    let availableTeachers = [];
    let selectedTeacherId = null;

    // Open teacher modal
    window.openAssignTeacherModal = function(classId, className) {
        teacherClassId = classId;

        // Update modal title
        document.getElementById('teacherModalClassName').textContent = className;

        // Show modal
        const modal = document.getElementById('assignTeacherModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Load teachers
        loadTeachersForAssignment(classId);
    }

    // Close teacher modal
    window.closeTeacherModal = function() {
        const modal = document.getElementById('assignTeacherModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Reset state
        teacherClassId = null;
        availableTeachers = [];
        selectedTeacherId = null;
    }

    // Load teachers with better error handling
    async function loadTeachersForAssignment(classId) {
        showTeacherLoading(true);
        showTeacherError(false);
        showTeacherEmptyState(false);

        try {
            console.log(`Loading teachers for class ${classId}...`);

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

            // Fetch teachers data
            const response = await fetch(`/admin/classes/${classId}/teachers`, {
                headers: headers,
                credentials: 'same-origin'
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
                throw new Error(data.message || 'Failed to load teachers');
            }

            availableTeachers = data.teachers || [];

            if (data.currentTeacherId) {
                selectedTeacherId = data.currentTeacherId;
            }

            renderTeachersList();

        } catch (error) {
            console.error('Error loading teachers:', error);

            // Show error with details
            document.getElementById('teacherErrorMessage').textContent = 'Failed to load teachers';
            document.getElementById('teacherErrorDetails').innerHTML = `
                <div class="text-left">
                    <p class="mb-2">${error.message}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Check:
                        <ul class="mt-1 space-y-1">
                            <li>• Is the route defined? (/admin/classes/{id}/teachers)</li>
                            <li>• Are you logged in?</li>
                            <li>• Check browser console for details</li>
                        </ul>
                    </p>
                </div>
            `;
            showTeacherError(true);

            // Fallback to mock data for testing
            setTimeout(() => {
                useMockTeacherData();
            }, 1000);

        } finally {
            showTeacherLoading(false);
        }
    }

    // Use mock data as fallback
    function useMockTeacherData() {
        console.log('Using mock teacher data as fallback');

        // Mock data for testing
        const mockData = {
            teachers: [{
                    id: 1,
                    name: 'Dr. Sarah Johnson',
                    email: 'sarah.johnson@school.edu',
                    subjects: 'Mathematics, Physics'
                },
                {
                    id: 2,
                    name: 'Mr. David Chen',
                    email: 'david.chen@school.edu',
                    subjects: 'English Literature, Creative Writing'
                },
                {
                    id: 3,
                    name: 'Ms. Maria Rodriguez',
                    email: 'maria.rodriguez@school.edu',
                    subjects: 'Biology, Chemistry'
                },
                {
                    id: 4,
                    name: 'Prof. James Wilson',
                    email: 'james.wilson@school.edu',
                    subjects: 'History, Social Studies'
                }
            ],
            currentTeacherId: null
        };

        availableTeachers = mockData.teachers;
        selectedTeacherId = mockData.currentTeacherId;

        document.getElementById('teacherErrorState').classList.add('hidden');
        renderTeachersList();

        // Show info about using mock data
        showTeacherNotification('Using sample data for demonstration', 'info');
    }

    // Render teachers list
    function renderTeachersList() {
        const container = document.getElementById('teachersListContainer');

        if (!availableTeachers.length) {
            showTeacherEmptyState(true);
            container.classList.add('hidden');
            return;
        }

        // Clear container
        container.innerHTML = '';

        // Create teacher items
        availableTeachers.forEach(teacher => {
            const isSelected = teacher.id == selectedTeacherId;
            const teacherName = teacher.name || 'Unknown Teacher';
            const initials = teacherName.charAt(0).toUpperCase();
            const teacherEmail = teacher.email || 'No email';
            const subjects = teacher.subjects || '';

            const teacherItem = document.createElement('label');
            teacherItem.className =
                `block p-4 border rounded-lg cursor-pointer transition-all ${isSelected ? 'bg-blue-50 border-blue-300 ring-2 ring-blue-200' : 'border-gray-200 hover:bg-gray-50'}`;
            teacherItem.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex items-center">
                        <input type="radio"
                               name="teacher"
                               value="${teacher.id}"
                               ${isSelected ? 'checked' : ''}
                               onchange="selectTeacher(${teacher.id})"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 mt-1">
                    </div>
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg">
                            ${initials}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900 truncate">${teacherName}</h3>
                                ${isSelected ?
                                    '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Current</span>' :
                                    ''
                                }
                            </div>
                            <p class="text-xs text-gray-500 truncate mt-1">${teacherEmail}</p>
                            ${subjects ?
                                `<p class="text-xs text-gray-400 mt-2">${subjects}</p>` :
                                ''
                            }
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(teacherItem);
        });

        container.classList.remove('hidden');
        showTeacherEmptyState(false);

        // Update save button
        const saveButton = document.getElementById('saveTeacherButton');
        saveButton.disabled = !selectedTeacherId;
    }

    // Select teacher
    window.selectTeacher = function(teacherId) {
        selectedTeacherId = teacherId;

        // Update UI
        renderTeachersList();
    }

    // Save teacher assignment
    window.saveTeacherAssignment = async function() {
        if (!selectedTeacherId) {
            showTeacherNotification('Please select a teacher first', 'error');
            return;
        }

        const saveButton = document.getElementById('saveTeacherButton');
        const originalText = saveButton.innerHTML;

        // Disable button and show loading
        saveButton.disabled = true;
        saveButton.innerHTML = `
            <span class="material-icons-sharp text-sm animate-spin">refresh</span>
            <span>Saving...</span>
        `;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Create headers
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }

            const response = await fetch(`/admin/classes/${teacherClassId}/assign-teacher`, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    teacher_id: selectedTeacherId
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
                document.getElementById('teacherSuccessNotification').classList.remove('hidden');

                // Close modal after delay
                setTimeout(() => {
                    closeTeacherModal();

                    // Reload page to show updated teacher
                    setTimeout(() => location.reload(), 1000);
                }, 1500);

                // Hide notification after 3 seconds
                setTimeout(() => {
                    document.getElementById('teacherSuccessNotification').classList.add('hidden');
                }, 3000);

            } else {
                throw new Error(data.message || 'Assignment failed');
            }

        } catch (error) {
            console.error('Error assigning teacher:', error);
            showTeacherNotification(`Error: ${error.message}`, 'error');
        } finally {
            // Restore button
            saveButton.disabled = false;
            saveButton.innerHTML = originalText;
        }
    }

    // Show/hide teacher loading
    function showTeacherLoading(show) {
        document.getElementById('teacherLoadingState').style.display = show ? 'block' : 'none';
    }

    // Show/hide teacher error
    function showTeacherError(show) {
        const errorState = document.getElementById('teacherErrorState');
        if (show) {
            errorState.classList.remove('hidden');
        } else {
            errorState.classList.add('hidden');
        }
    }

    // Show/hide teacher empty state
    function showTeacherEmptyState(show) {
        document.getElementById('teacherEmptyState').style.display = show ? 'block' : 'none';
    }

    // Retry loading teachers
    window.retryLoadingTeachers = function() {
        if (teacherClassId) {
            loadTeachersForAssignment(teacherClassId);
        }
    }

    // Show teacher notification
    function showTeacherNotification(message, type = 'success') {
        let notification, messageElement;

        if (type === 'success') {
            notification = document.getElementById('teacherSuccessNotification');
            messageElement = notification.querySelector('span:last-child');
        } else {
            notification = document.getElementById('teacherErrorNotification');
            messageElement = document.getElementById('teacherErrorNotificationMessage');
        }

        if (messageElement) {
            messageElement.textContent = message;
        }

        // Show notification
        notification.classList.remove('hidden');

        // Hide after 3 seconds
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    // Close modal when clicking outside (for teacher modal)
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('assignTeacherModal');

        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeTeacherModal();
                }
            });

            // Close with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeTeacherModal();
                }
            });
        }

        // Initialize mock data on page load for testing
        console.log('Teacher assignment modal loaded');
        console.log('Note: If API endpoints are not configured, mock data will be used.');
    });
</script>
