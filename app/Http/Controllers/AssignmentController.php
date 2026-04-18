<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 👈 add this

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::where('teacher_id', Auth::id()) // 👈
            ->withCount('submissions')
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'subject'     => ['required', 'string', 'max:255'],
            'due_date'    => ['required', 'date', 'after:now'],
        ]);

        Assignment::create([
            'teacher_id'  => Auth::id(), // 👈
            'title'       => $request->title,
            'description' => $request->description,
            'subject'     => $request->subject,
            'due_date'    => $request->due_date,
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully!');
    }

    public function edit(Assignment $assignment)
    {
        abort_if($assignment->teacher_id !== Auth::id(), 403); // 👈

        return view('assignments.edit', compact('assignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        abort_if($assignment->teacher_id !== Auth::id(), 403); // 👈

        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'subject'     => ['required', 'string', 'max:255'],
            'due_date'    => ['required', 'date'],
        ]);

        $assignment->update($request->only('title', 'description', 'subject', 'due_date'));

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully!');
    }

    public function destroy(Assignment $assignment)
    {
        abort_if($assignment->teacher_id !== Auth::id(), 403); // 👈

        $assignment->delete();

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully!');
    }
}