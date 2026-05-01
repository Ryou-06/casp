<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::where('teacher_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function show(Classroom $classroom)
    {
        $this->authorizeTeacherClassroom($classroom);

        $classroom->load(['students' => fn ($query) => $query->orderBy('name'), 'assignments']);

        $studentIds = $classroom->students->pluck('id');
        $availableStudents = User::where('role', 'student')
            ->whereNotIn('id', $studentIds)
            ->orderBy('name')
            ->get();

        return view('classrooms.show', compact('classroom', 'availableStudents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Classroom::create([
            ...$validated,
            'teacher_id' => Auth::id(),
        ]);

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom created successfully!');
    }

    public function edit(Classroom $classroom)
    {
        $this->authorizeTeacherClassroom($classroom);

        return view('classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherClassroom($classroom);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $classroom->update($validated);

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom updated successfully!');
    }

    public function destroy(Classroom $classroom)
    {
        $this->authorizeTeacherClassroom($classroom);

        $classroom->delete();

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom deleted successfully.');
    }

    public function addStudent(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherClassroom($classroom);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::where('role', 'student')->findOrFail($validated['student_id']);

        $classroom->students()->syncWithoutDetaching([$student->id]);

        return redirect()->route('classrooms.show', $classroom)
            ->with('success', 'Student added to classroom successfully!');
    }

    public function removeStudent(Classroom $classroom, User $student)
    {
        $this->authorizeTeacherClassroom($classroom);

        if (! $student->isStudent()) {
            abort(404);
        }

        $classroom->students()->detach($student->id);

        return redirect()->route('classrooms.show', $classroom)
            ->with('success', 'Student removed from classroom.');
    }

    public function studentIndex()
    {
        $classrooms = Auth::user()
            ->enrolledClassrooms()
            ->withCount('assignments')
            ->latest('classroom_student.created_at')
            ->paginate(10);

        return view('classrooms.student_index', compact('classrooms'));
    }

    public function studentShow(Classroom $classroom)
    {
        $student = Auth::user();

        if (! $student->enrolledClassrooms()->where('classrooms.id', $classroom->id)->exists()) {
            abort(403);
        }

        $classroom->load(['assignments' => fn ($query) => $query->orderBy('due_date')]);

        return view('classrooms.student_show', compact('classroom'));
    }

    private function authorizeTeacherClassroom(Classroom $classroom): void
    {
        if ($classroom->teacher_id !== Auth::id()) {
            abort(403);
        }
    }
}
