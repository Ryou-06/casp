<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Display a listing of assignments for students to submit.
     */
    public function index()
    {
        $student = Auth::user();
        
        $assignments = Assignment::whereHas('classroom.students', function ($query) use ($student) {
            $query->where('users.id', $student->id);
        })
        ->with(['classroom', 'submissions' => function($query) use ($student) {
            $query->where('student_id', $student->id);
        }])
        ->orderBy('due_date', 'asc')
        ->paginate(10);
        
        // Add a flag to each assignment indicating if student has submitted
        foreach ($assignments as $assignment) {
            $assignment->submissions_exists = $assignment->submissions->isNotEmpty();
        }
        
        return view('submissions.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new submission.
     */
    public function create(Assignment $assignment)
{
    $this->ensureStudentCanAccessAssignment($assignment);

    // Check if assignment is past due
    if ($assignment->isPastDue()) {
        return redirect()->route('submissions.index')
            ->with('error', 'This assignment is past due and cannot accept submissions.');
    }

    // Check if student already submitted
    $existing = Submission::where('assignment_id', $assignment->id)
        ->where('student_id', Auth::id())
        ->first();

    // Pass $existing to the view
    return view('submissions.create', compact('assignment', 'existing'));
}

    /**
     * Store a newly created submission in storage.
     */
    public function store(Request $request, Assignment $assignment)
    {
        $this->ensureStudentCanAccessAssignment($assignment);

        // Validate
        $request->validate([
            'file' => 'required|file|max:512000', // 500MB in KB
        ]);
        
        // Check if assignment is past due
        if ($assignment->isPastDue()) {
            return redirect()->route('submissions.index')
                ->with('error', 'This assignment is past due. Submission denied.');
        }
        
        // Handle file upload
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        
        // Generate unique filename to prevent conflicts
        $filename = time() . '_' . Auth::id() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $filePath = $file->storeAs('submissions/' . $assignment->id, $filename, 'public');
        
        // Check if submission already exists (update vs create)
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', Auth::id())
            ->first();
            
        if ($submission) {
            // Delete old file if exists
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
            
            // Update existing submission
            $submission->update([
                'file_path' => $filePath,
                'file_name' => $originalName,
                'file_size' => $fileSize,
                'submitted_at' => now(),
            ]);
            
            $message = 'Your submission has been updated successfully!';
        } else {
            // Create new submission
            Submission::create([
                'assignment_id' => $assignment->id,
                'student_id' => Auth::id(),
                'file_path' => $filePath,
                'file_name' => $originalName,
                'file_size' => $fileSize,
                'submitted_at' => now(),
            ]);
            
            $message = 'Assignment submitted successfully!';
        }
        
        return redirect()->route('submissions.index')
            ->with('success', $message);
    }
    
    /**
     * Display all submissions for a specific assignment (Teacher only)
     */
    public function showSubmissionsForTeacher(Assignment $assignment)
    {
        // Verify teacher owns this assignment
        if (Auth::user()->role !== 'teacher' || $assignment->teacher_id !== Auth::id()) {
            abort(403, 'You do not have permission to view these submissions.');
        }
        
        // Get all submissions with student details, ordered by submission date
        $submissions = $assignment->submissions()
            ->with('student')
            ->orderBy('submitted_at', 'desc')
            ->paginate(15);
        
        return view('submissions.teacher_index', compact('assignment', 'submissions'));
    }
    
    /**
     * Display submission history for all assignments (Teacher dashboard)
     */
    public function allSubmissionsHistory()
    {
        // Verify user is teacher
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized access.');
        }
        
        // Get all submissions for assignments created by this teacher
        $submissions = Submission::whereHas('assignment', function($query) {
            $query->where('teacher_id', Auth::id());
        })
        ->with(['assignment', 'student'])
        ->orderBy('submitted_at', 'desc')
        ->paginate(20);
        
        return view('submissions.history', compact('submissions'));
    }

    private function ensureStudentCanAccessAssignment(Assignment $assignment): void
    {
        $student = Auth::user();

        if (! $assignment->classroom_id) {
            abort(403, 'You are not enrolled in the classroom for this assignment.');
        }

        $isEnrolled = $assignment->classroom()
            ->whereHas('students', function ($query) use ($student) {
                $query->where('users.id', $student->id);
            })
            ->exists();

        if (! $isEnrolled) {
            abort(403, 'You are not enrolled in the classroom for this assignment.');
        }
    }
}
