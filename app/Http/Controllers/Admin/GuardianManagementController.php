<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;

class GuardianManagementController extends Controller
{
    public function index()
    {
        $guardians = Guardian::with(['user', 'students'])
            ->latest()
            ->paginate(20);

        return view('guardians.index', compact('guardians'));
    }

    public function create()
    {
        $students = Student::active()->get();
        return view('admin.guardians.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'relationship' => 'required|string|max:100',
            'occupation' => 'nullable|string|max:255',
            'employer' => 'nullable|string|max:255',
            'work_phone' => 'nullable|string|max:20',
            'work_email' => 'nullable|email|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
            'medical_notes' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_primary' => 'boolean',
            'can_pickup' => 'boolean',
            'receive_sms_alerts' => 'boolean',
            'receive_email_alerts' => 'boolean',
            'is_active' => 'boolean',
        ]);
        $guardian = Guardian::create($validated);
        if ($request->has('student_ids')) {
            $guardian->students()->attach($request->input('student_ids'));
        }
        return redirect()->route('guardians.index')
            ->with('success', 'Guardian created successfully.');
    }

    public function show(Guardian $guardian)
    {
        $guardian->load(['user', 'students', 'addresses']);
        return view('guardians.show', compact('guardian'));
    }

    public function edit(Guardian $guardian)
    {
        $guardian->load('user');
        return view('guardians.edit', compact('guardian'));
    }

    public function update(Request $request, Guardian $guardian)
    {
        // Validation and update logic here
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        return redirect()->route('guardians.index')
            ->with('success', 'Guardian deleted successfully.');
    }
}
