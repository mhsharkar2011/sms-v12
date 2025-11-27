<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // FIXED: Changed 'app' to 'App'
use App\Models\Student;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StudentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $roleFilter = $request->get('role');
        $status = $request->get('status');
        $search = $request->get('search');

        // Build query with filters
        $students = Student::query()
            ->when($roleFilter, function ($query, $roleFilter) {
                return $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('name', $roleFilter);
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Calculate statistics
        $stats = [
            'totalStudents' => Student::count(),
            'activeStudents' => Student::where('status', 'active')->count(),
            'pendingStudents' => Student::where('status', 'pending')->count(),
            'inactiveStudents' => Student::where('status', 'inactive')->count(),
        ];

        // Get available roles for filter
        $roles = Role::all();

        return view('admin.students.index', compact('students', 'stats', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
