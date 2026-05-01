<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  // Add this line at the top with other imports
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = Assignment::where('teacher_id', Auth::id())
            ->with('classroom')
            ->withCount('submissions')
            ->latest()
            ->paginate(10);
            
        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::where('teacher_id', Auth::id())->orderBy('name')->get();

        return view('assignments.create', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'due_date' => 'required|date|after:now',
        ]);

        $classroom = Classroom::where('teacher_id', Auth::id())->findOrFail($request->classroom_id);
        $subject = $classroom->subject ?: $request->subject;

        if (! $subject) {
            return back()
                ->withErrors(['subject' => 'Add a subject to the classroom or provide one for this assignment.'])
                ->withInput();
        }

        Assignment::create([
            'teacher_id' => Auth::id(),
            'classroom_id' => $classroom->id,
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $subject,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('classrooms.show', $classroom)
            ->with('success', 'Assignment created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        // Check if teacher owns this assignment
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        return view('assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        // Check if teacher owns this assignment
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        $classrooms = Classroom::where('teacher_id', Auth::id())->orderBy('name')->get();

        return view('assignments.edit', compact('assignment', 'classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        // Check if teacher owns this assignment
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'due_date' => 'required|date',
        ]);

        $classroom = Classroom::where('teacher_id', Auth::id())->findOrFail($request->classroom_id);
        $subject = $classroom->subject ?: $request->subject;

        if (! $subject) {
            return back()
                ->withErrors(['subject' => 'Add a subject to the classroom or provide one for this assignment.'])
                ->withInput();
        }

        $assignment->update([
            'classroom_id' => $classroom->id,
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $subject,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        // Check if teacher owns this assignment
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        // Delete all submission files
        foreach($assignment->submissions as $submission) {
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
        }
        
        $assignment->delete();
        
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }
}
