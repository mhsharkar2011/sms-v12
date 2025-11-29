<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subject::query();

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        $subjects = $query->latest()->paginate(10);

        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Check if request data is coming through
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects',
            'description' => 'nullable|string',
            'category' => 'required|in:core,elective,extracurricular,vocational',
            'credit_hours' => 'required|integer|min:1|max:10',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'is_active' => 'sometimes|boolean'
        ]);

        // Debug: Check validated data
        // dd($validated);

        try {
            // Handle checkbox boolean value
            $validated['is_active'] = $request->has('is_active');

            $subject = Subject::create($validated);

            // Debug: Check if subject was created
            // dd($subject);

            return redirect()->route('admin.subjects.index')
                ->with('success', 'Subject created successfully.');
        } catch (\Exception $e) {
            // Debug: Check for any exceptions
            // dd($e->getMessage());

            return redirect()->back()
                ->with('error', 'Error creating subject: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'category' => 'required|in:core,elective,extracurricular,vocational',
            'credit_hours' => 'required|integer|min:1|max:10',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean'
        ]);

        $subject->update($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
