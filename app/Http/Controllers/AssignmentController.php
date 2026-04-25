<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
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
        return view('assignments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'due_date' => 'required|date|after:now',
        ]);

        Assignment::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $request->subject,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('assignments.index')
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
        
        return view('assignments.edit', compact('assignment'));
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'due_date' => 'required|date',
        ]);

        $assignment->update($request->all());

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