<div class="mb-4">
    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
    <select name="subject" id="subject" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" onchange="loadTeachers()">
        <option value="">Select Subject</option>
        <option value="Mathematics">Mathematics</option>
        <option value="Physics">Physics</option>
        <option value="Biology">Biology</option>
        <option value="Chemistry">Chemistry</option>
    </select>
</div>

<div class="mb-4">
    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Teacher</label>
    <select name="teacher_id" id="teacher_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
        <option value="">Select Teacher</option>
        <!-- Teachers will be loaded dynamically -->
    </select>
</div>

<script>
function loadTeachers() {
    const subject = document.getElementById('subject').value;
    if (!subject) return;

    fetch(`/api/teachers/available/${subject}`)
        .then(response => response.json())
        .then(teachers => {
            const teacherSelect = document.getElementById('teacher_id');
            teacherSelect.innerHTML = '<option value="">Select Teacher</option>';

            teachers.forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher.teacher_id;
                option.textContent = `${teacher.teacher.name} (${teacher.proficiency_level})`;
                teacherSelect.appendChild(option);
            });
        });
}
</script>
