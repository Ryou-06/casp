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
        return redirect()->route('student.dashboard');
    }

    /**
     * Show the form for creating a new submission.
     */
/**
 * Show the form for creating a new submission.
 */
public function create(Assignment $assignment)
{
    $this->ensureStudentCanAccessAssignment($assignment);
    
    // Remove the past due check - allow submissions always
    
    // Check if student already submitted
    $existing = Submission::where('assignment_id', $assignment->id)
        ->where('student_id', Auth::id())
        ->first();
    
    // Pass flag to show if it's past due (for informational purposes)
    $isPastDue = $assignment->isPastDue();
    if ($existing) {
        $existing->is_late = $assignment->isSubmissionLate($existing->submitted_at);
    }
    
    return view('submissions.create', compact('assignment', 'existing', 'isPastDue'));
}

/**
 * Store a newly created submission in storage.
 */
public function store(Request $request, Assignment $assignment)
{
    $this->ensureStudentCanAccessAssignment($assignment);
    
    // Validate
    $request->validate([
        'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,jpg,jpeg,png|max:512000',
    ]);
    
    // Remove the past due blocking check - allow submissions always
    
    // Handle file upload
    $file = $request->file('file');
    $originalName = $file->getClientOriginalName();
    $fileSize = $file->getSize();
    
    // Generate unique filename to prevent conflicts
    $filename = time() . '_' . Auth::id() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
    $filePath = $file->storeAs('submissions/' . $assignment->id, $filename, 'public');
    
    $submittedAt = now();
    $isLate = $assignment->isSubmissionLate($submittedAt);
    
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
            'submitted_at' => $submittedAt,
        ]);
        
        $message = 'Your submission has been updated successfully!';
        if ($isLate) {
            $message .= ' (Submitted late)';
        }
    } else {
        // Create new submission
        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => Auth::id(),
            'file_path' => $filePath,
            'file_name' => $originalName,
            'file_size' => $fileSize,
            'submitted_at' => $submittedAt,
        ]);
        
        $message = 'Assignment submitted successfully!';
        if ($isLate) {
            $message .= ' (Submitted late)';
        }
    }
    
    return redirect()->route('student.classrooms.show', $assignment->classroom)
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
    
    // Add late status to each submission
    foreach ($submissions as $submission) {
        $submission->is_late = $assignment->isSubmissionLate($submission->submitted_at);
    }
    
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
    
    // Add late status to each submission
    foreach ($submissions as $submission) {
        $submission->is_late = $submission->assignment->isSubmissionLate($submission->submitted_at);
    }
    
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
