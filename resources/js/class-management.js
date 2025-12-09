class ClassManagement {
    constructor() {
        this.currentModal = null;
        this.currentClassId = null;
        this.csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        this.initEventListeners();
    }

    initEventListeners() {
        // Dropdown functionality
        document.addEventListener("DOMContentLoaded", () => {
            this.initDropdowns();
        });
    }

    initDropdowns() {
        document.querySelectorAll(".dropdown-toggle").forEach((button) => {
            button.addEventListener("click", (e) => {
                e.stopPropagation();
                const dropdown = button.nextElementSibling;
                dropdown.classList.toggle("hidden");
            });
        });

        document.addEventListener("click", () => {
            document.querySelectorAll(".dropdown-menu").forEach((dropdown) => {
                dropdown.classList.add("hidden");
            });
        });
    }

    // Student Assignment Modal
    openAssignStudentModal(classId, className) {
        this.closeCurrentModal();
        this.currentClassId = classId;

        // Create modal
        const modalHtml = `
            <div id="assignStudentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Assign Students to ${className}</h2>
                            <p class="text-gray-600 mt-1">Add or remove students from this class</p>
                        </div>
                        <button onclick="classManagement.closeCurrentModal()"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-icons-sharp">close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Students</label>
                            <input type="text"
                                   id="studentSearch"
                                   onkeyup="classManagement.searchStudents()"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Search by name, ID, or email...">
                        </div>

                        <!-- Students List -->
                        <div id="studentsListContainer" class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
                            <div class="p-4 text-center">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                                <p class="text-gray-500 text-sm mt-2">Loading students...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50">
                        <button onclick="classManagement.closeCurrentModal()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button onclick="classManagement.saveStudentAssignments()"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">save</span>
                            <span>Save Assignments</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML("beforeend", modalHtml);
        this.currentModal = document.getElementById("assignStudentModal");

        // Load students
        this.loadStudentsForAssignment(classId);

        // Close on click outside
        this.currentModal.addEventListener("click", (e) => {
            if (e.target === this.currentModal) {
                this.closeCurrentModal();
            }
        });
    }

    async loadStudentsForAssignment(classId) {
        const modalBody = document.getElementById("studentsListContainer");
        if (!modalBody) return;

        try {
            const response = await fetch(`/admin/classes/${classId}/students`);

            if (!response.ok) {
                throw new Error("Failed to load students");
            }

            const data = await response.json();
            this.renderStudentsList(data.students, data.assignedStudents);
        } catch (error) {
            console.error("Error loading students:", error);
            modalBody.innerHTML = `
                <div class="p-4 text-center">
                    <p class="text-red-500 text-sm">Error loading students: ${error.message}</p>
                    <button onclick="classManagement.loadStudentsForAssignment(${classId})"
                            class="mt-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                        Retry
                    </button>
                </div>
            `;
        }
    }

    renderStudentsList(students, assignedStudents) {
        const modalBody = document.getElementById("studentsListContainer");
        if (!modalBody) return;

        if (!students || students.length === 0) {
            modalBody.innerHTML = `
                <div class="p-4 text-center">
                    <p class="text-gray-500 text-sm">No students found.</p>
                </div>
            `;
            return;
        }

        let html = '<div class="divide-y divide-gray-200">';

        students.forEach((student) => {
            const isAssigned = assignedStudents.includes(student.id);
            const fullName = `${student.first_name || ""} ${
                student.last_name || ""
            }`.trim();

            html += `
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                                ${fullName.charAt(0) || "?"}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    ${fullName}
                                </div>
                                <div class="text-xs text-gray-500">
                                    ${student.student_id || "N/A"} • ${
                student.email || "No email"
            }
                                </div>
                            </div>
                        </div>
                        <label class="inline-flex items-center">
                            <input type="checkbox"
                                   ${isAssigned ? "checked" : ""}
                                   data-student-id="${student.id}"
                                   class="student-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-5 w-5">
                        </label>
                    </div>
                </div>
            `;
        });

        html += "</div>";
        modalBody.innerHTML = html;
    }

    searchStudents() {
        const searchInput = document.getElementById("studentSearch");
        const searchTerm = searchInput.value.toLowerCase();
        const studentItems = document.querySelectorAll(
            "#studentsListContainer > div > div"
        );

        studentItems.forEach((item) => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? "" : "none";
        });
    }

    async saveStudentAssignments() {
        if (!this.currentClassId) return;

        const checkboxes = document.querySelectorAll(
            ".student-checkbox:checked"
        );
        const assignedStudentIds = Array.from(checkboxes).map((checkbox) =>
            parseInt(checkbox.getAttribute("data-student-id"))
        );

        const saveButton = document.querySelector(
            '#assignStudentModal button[onclick*="saveStudentAssignments"]'
        );
        if (!saveButton) return;

        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = `
            <span class="material-icons-sharp text-sm animate-spin">refresh</span>
            <span>Saving...</span>
        `;
        saveButton.disabled = true;

        try {
            const response = await fetch(
                `/admin/classes/${this.currentClassId}/assign-students`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": this.csrfToken,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        student_ids: assignedStudentIds,
                    }),
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Failed to assign students");
            }

            if (data.success) {
                this.showNotification(
                    "Students assigned successfully!",
                    "success"
                );
                this.closeCurrentModal();

                // Optional: Reload page or update specific elements
                if (data.should_reload) {
                    setTimeout(() => location.reload(), 1000);
                }
            } else {
                throw new Error(data.message || "Assignment failed");
            }
        } catch (error) {
            console.error("Error saving assignments:", error);
            this.showNotification(`Error: ${error.message}`, "error");
        } finally {
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        }
    }

    // Teacher Assignment Modal
    openAssignTeacherModal(classId, className) {
        this.closeCurrentModal();
        this.currentClassId = classId;

        const modalHtml = `
            <div id="assignTeacherModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-hidden">
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Assign Teacher to ${className}</h2>
                            <p class="text-gray-600 mt-1">Select a teacher for this class</p>
                        </div>
                        <button onclick="classManagement.closeCurrentModal()"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-icons-sharp">close</span>
                        </button>
                    </div>

                    <div class="p-6">
                        <div id="teacherListContainer" class="max-h-96 overflow-y-auto">
                            <div class="text-center py-4">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                                <p class="text-gray-500 text-sm mt-2">Loading teachers...</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50">
                        <button onclick="classManagement.closeCurrentModal()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button onclick="classManagement.saveTeacherAssignment()"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">save</span>
                            <span>Assign Teacher</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML("beforeend", modalHtml);
        this.currentModal = document.getElementById("assignTeacherModal");

        this.loadTeachersForAssignment(classId);

        this.currentModal.addEventListener("click", (e) => {
            if (e.target === this.currentModal) {
                this.closeCurrentModal();
            }
        });
    }

    async loadTeachersForAssignment(classId) {
        const modalBody = document.getElementById("teacherListContainer");
        if (!modalBody) return;

        try {
            const response = await fetch(`/admin/classes/${classId}/teachers`);

            if (!response.ok) {
                throw new Error("Failed to load teachers");
            }

            const data = await response.json();
            this.renderTeachersList(data.teachers, data.currentTeacherId);
        } catch (error) {
            console.error("Error loading teachers:", error);
            modalBody.innerHTML = `
                <div class="p-4 text-center">
                    <p class="text-red-500 text-sm">Error loading teachers: ${error.message}</p>
                    <button onclick="classManagement.loadTeachersForAssignment(${classId})"
                            class="mt-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                        Retry
                    </button>
                </div>
            `;
        }
    }

    renderTeachersList(teachers, currentTeacherId) {
        const modalBody = document.getElementById("teacherListContainer");
        if (!modalBody) return;

        if (!teachers || teachers.length === 0) {
            modalBody.innerHTML = `
                <div class="p-4 text-center">
                    <p class="text-gray-500 text-sm">No available teachers found.</p>
                </div>
            `;
            return;
        }

        let html = '<div class="space-y-3">';

        teachers.forEach((teacher) => {
            const isCurrent = teacher.id == currentTeacherId;
            const teacherName = teacher.user?.name || teacher.name || "Unknown";
            const teacherEmail =
                teacher.user?.email || teacher.email || "No email";

            html += `
                <label class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors ${
                    isCurrent ? "bg-blue-50 border-blue-200" : ""
                }">
                    <div class="flex items-center space-x-3">
                        <input type="radio"
                               name="teacher_id"
                               value="${teacher.id}"
                               ${isCurrent ? "checked" : ""}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                ${teacherName.charAt(0)}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${teacherName}</div>
                                <div class="text-xs text-gray-500">${teacherEmail}</div>
                                ${
                                    teacher.subjects
                                        ? `<div class="text-xs text-gray-400 mt-1">Subjects: ${teacher.subjects}</div>`
                                        : ""
                                }
                            </div>
                        </div>
                    </div>
                </label>
            `;
        });

        html += "</div>";
        modalBody.innerHTML = html;
    }

    async saveTeacherAssignment() {
        if (!this.currentClassId) return;

        const selectedTeacher = document.querySelector(
            'input[name="teacher_id"]:checked'
        );
        if (!selectedTeacher) {
            this.showNotification("Please select a teacher", "error");
            return;
        }

        const teacherId = selectedTeacher.value;
        const saveButton = document.querySelector(
            '#assignTeacherModal button[onclick*="saveTeacherAssignment"]'
        );

        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = `
            <span class="material-icons-sharp text-sm animate-spin">refresh</span>
            <span>Saving...</span>
        `;
        saveButton.disabled = true;

        try {
            const response = await fetch(
                `/admin/classes/${this.currentClassId}/assign-teacher`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": this.csrfToken,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        teacher_id: teacherId,
                    }),
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Failed to assign teacher");
            }

            if (data.success) {
                this.showNotification(
                    "Teacher assigned successfully!",
                    "success"
                );
                this.closeCurrentModal();

                // Reload to show updated teacher
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || "Assignment failed");
            }
        } catch (error) {
            console.error("Error saving teacher assignment:", error);
            this.showNotification(`Error: ${error.message}`, "error");
        } finally {
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        }
    }

    closeCurrentModal() {
        if (this.currentModal) {
            this.currentModal.remove();
            this.currentModal = null;
            this.currentClassId = null;
        }
    }

    showNotification(message, type = "info") {
        // Remove any existing notifications
        document
            .querySelectorAll(".global-notification")
            .forEach((n) => n.remove());

        const notification = document.createElement("div");
        notification.className = `global-notification fixed top-4 right-4 p-4 rounded-lg text-white z-50 animate-slide-in ${
            type === "success"
                ? "bg-green-500"
                : type === "error"
                ? "bg-red-500"
                : "bg-blue-500"
        }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add("animate-slide-out");
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

// Initialize
const classManagement = new ClassManagement();

// Make it globally available
window.classManagement = classManagement;

// Global functions
window.openAssignStudentModal = (classId, className) =>
    classManagement.openAssignStudentModal(classId, className);
window.openAssignTeacherModal = (classId, className) =>
    classManagement.openAssignTeacherModal(classId, className);
window.closeAssignStudentModal = () => classManagement.closeCurrentModal();
