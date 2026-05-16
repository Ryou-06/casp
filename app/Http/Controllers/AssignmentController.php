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
            'classroom_id' => ['required', 'integer', 'exists:classrooms,id'],
            'title' => ['required', 'string', 'max:255', 'regex:/[A-Za-z]/', 'not_regex:/^\d+$/'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'subject' => ['nullable', 'string', 'max:255', 'regex:/[A-Za-z]/', 'not_regex:/^\d+$/'],
            'due_date' => ['required', 'date', 'after:now'],
            'attachment' => ['nullable', 'file', 'max:512000'],
        ], $this->validationMessages());

        $classroom = Classroom::where('teacher_id', Auth::id())->findOrFail($request->classroom_id);
        $subject = $classroom->subject ?: $request->subject;

        if (! $subject) {
            return back()
                ->withErrors(['subject' => 'Add a subject to the classroom or provide one for this assignment.'])
                ->withInput();
        }

        $attachment = $this->storeAttachment($request, null);

        Assignment::create([
            'teacher_id' => Auth::id(),
            'classroom_id' => $classroom->id,
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $subject,
            'due_date' => $request->due_date,
            ...$attachment,
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
            'classroom_id' => ['required', 'integer', 'exists:classrooms,id'],
            'title' => ['required', 'string', 'max:255', 'regex:/[A-Za-z]/', 'not_regex:/^\d+$/'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'subject' => ['nullable', 'string', 'max:255', 'regex:/[A-Za-z]/', 'not_regex:/^\d+$/'],
            'due_date' => ['required', 'date', 'after:now'],
            'attachment' => ['nullable', 'file', 'max:512000'],
        ], $this->validationMessages());

        $classroom = Classroom::where('teacher_id', Auth::id())->findOrFail($request->classroom_id);
        $subject = $classroom->subject ?: $request->subject;

        if (! $subject) {
            return back()
                ->withErrors(['subject' => 'Add a subject to the classroom or provide one for this assignment.'])
                ->withInput();
        }

        $attachment = $this->storeAttachment($request, $assignment);

        $assignment->update([
            'classroom_id' => $classroom->id,
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $subject,
            'due_date' => $request->due_date,
            ...$attachment,
        ]);

        return redirect()->route('classrooms.show', $assignment->classroom)
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
        
        $classroom = $assignment->classroom;

        $this->deleteAttachment($assignment);

        $assignment->delete();
        
        return $classroom
            ? redirect()->route('classrooms.show', $classroom)->with('success', 'Assignment deleted successfully.')
            : redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }

    private function validationMessages(): array
    {
        return [
            'title.regex' => 'Assignment title must include letters and cannot be only numbers.',
            'title.not_regex' => 'Assignment title cannot be only numbers.',
            'description.min' => 'Instructions should be at least 10 characters.',
            'description.max' => 'Instructions must not be longer than 5,000 characters.',
            'subject.regex' => 'Subject must include letters, not only numbers.',
            'subject.not_regex' => 'Subject cannot be only numbers.',
            'due_date.after' => 'Deadline must be a future date and time.',
            'attachment.file' => 'Attachment must be a valid file.',
            'attachment.max' => 'Attachment must not be greater than 500MB.',
        ];
    }

    public function downloadAttachment(Assignment $assignment)
    {
        $user = Auth::user();

        if ($user->isTeacher()) {
            if ($assignment->teacher_id !== $user->id) {
                abort(403);
            }
        } elseif ($user->isStudent()) {
            $isEnrolled = $assignment->classroom()
                ->whereHas('students', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->exists();

            if (! $isEnrolled) {
                abort(403);
            }
        } else {
            abort(403);
        }

        if (! $assignment->attachment_path || ! Storage::disk('public')->exists($assignment->attachment_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($assignment->attachment_path, $assignment->attachment_name);
    }

    private function storeAttachment(Request $request, ?Assignment $assignment): array
    {
        if (! $request->hasFile('attachment')) {
            return [];
        }

        if ($assignment) {
            $this->deleteAttachment($assignment);
        }

        $file = $request->file('attachment');
        $originalName = $file->getClientOriginalName();
        $filename = time().'_'.Auth::id().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $path = $file->storeAs('assignment-attachments', $filename, 'public');

        return [
            'attachment_path' => $path,
            'attachment_name' => $originalName,
            'attachment_size' => $file->getSize(),
        ];
    }

    private function deleteAttachment(Assignment $assignment): void
    {
        if ($assignment->attachment_path && Storage::disk('public')->exists($assignment->attachment_path)) {
            Storage::disk('public')->delete($assignment->attachment_path);
        }
    }
}
