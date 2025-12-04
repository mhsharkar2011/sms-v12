<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get search query
        $search = $request->input('search');
        $status = $request->input('status');

        // Build query
        $query = Department::query();

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Order and paginate
        $departments = $query->latest()->paginate(15);

        // Get statistics
        $stats = [
            'total' => Department::count(),
            'active' => Department::where('is_active', true)->count(),
            'inactive' => Department::where('is_active', false)->count(),
        ];

        return view('departments.index', compact('departments', 'search', 'status', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'code' => 'required|string|max:10|unique:departments,code',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        // Create department
        $department = Department::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'description' => $validated['description'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department): View
    {
        // Load related data if needed
        $department->loadCount(['teachers', 'classes', 'subjects']);

        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        // Update department
        $department->update([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'description' => $validated['description'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): RedirectResponse
    {
        // Check for related records before deletion
        if ($department->teachers()->exists() || $department->classes()->exists() || $department->subjects()->exists()) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department with related records.');
        }

        // Delete department
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully!');
    }
}
