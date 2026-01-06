<?php
// app/Http/Controllers/SectionController.php
namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Classes;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Section::with(['class', 'teacher'])
            ->when($request->class_id, function ($q) use ($request) {
                return $q->where('class_id', $request->class_id);
            })
            ->when($request->is_active, function ($q) use ($request) {
                return $q->where('is_active', $request->is_active == 'active');
            })
            ->when($request->search, function ($q) use ($request) {
                return $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('code', 'like', "%{$request->search}%");
            });

        $sections = $query->latest()->paginate(20);
        $classes = SchoolClass::all();

        return view('admin.sections.index', compact('sections', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::active()->get();
        $teachers = Teacher::active()->get();
        $sectionCode = Section::generateSectionCode();
        $roomNumber = Section::generateRoomNumber();

        return view('admin.sections.create', compact('classes', 'teachers','sectionCode','roomNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'name' => 'required|string|max:100',
            'code' => 'required|string|unique:sections,code|max:10',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:100',
            'room_number' => 'required|string|min:1|max:1000',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            Section::create($validated);

            DB::commit();

            return redirect()->route('admin.sections.index')
                ->with('success', 'Section created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create section: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Section $section)
    {
        $section->load(['class', 'teacher', 'students' => function ($query) {
            $query->orderBy('name');
        }]);

        return view('admin.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        $classes = SchoolClass::active()->get();
        $teachers = Teacher::active()->get();

        return view('admin.sections.edit', compact('section', 'classes', 'teachers'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:sections,code,' . $section->id,
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:' . $section->students()->count() . '|max:100',
            'room_number' => 'nullable|integer|min:1|max:100',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $section->update($validated);

            DB::commit();

            return redirect()->route('admin.sections.index')
                ->with('success', 'Section updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update section: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function toggleStatus(Section $section)
    {
        $section->update(['is_active' => !$section->is_active]);

        $status = $section->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Section {$status} successfully.");
    }

    public function destroy(Section $section)
    {
        if ($section->students()->count() > 0) {
            return redirect()->route('admin.sections.index')
                ->with('error', 'Cannot delete section with students. Please transfer students first.');
        }

        $section->delete(); // This will soft delete if using SoftDeletes trait

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section deleted successfully.');
    }

    // Add these methods if you need to restore or force delete:
    public function restore($id)
    {
        $section = Section::withTrashed()->findOrFail($id);
        $section->restore();

        return redirect()->route('sections.index')
            ->with('success', 'Section restored successfully.');
    }

    public function forceDelete($id)
    {
        $section = Section::withTrashed()->findOrFail($id);

        if ($section->students()->count() > 0) {
            return redirect()->route('sections.index')
                ->with('error', 'Cannot permanently delete section with students.');
        }

        $section->forceDelete();

        return redirect()->route('sections.index')
            ->with('success', 'Section permanently deleted.');
    }
}
