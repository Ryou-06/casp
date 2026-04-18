<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    // Student: list all active assignments to submit
    public function index()
    {
        $assignments = Assignment::withExists('submissions', function($q) {
            $q->where('student_id', Auth::id());
        })->orderBy('due_date', 'asc')->paginate(10);

        return view('submissions.index', compact('assignments'));
    }

    // Student: show upload form for a specific assignment
    public function create(Assignment $assignment)
    {
        // Check if already submitted
        $existing = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', Auth::id())
            ->first();

        return view('submissions.create', compact('assignment', 'existing'));
    }

    // Student: store or replace submission
    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:512000', // 500MB in kilobytes
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,jpg,jpeg,png',
            ],
        ]);

        // Check if past due
        if ($assignment->isPastDue()) {
            return back()->with('error', 'This assignment is past due. Submissions are closed.');
        }

        // Handle file upload
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('submissions/' . $assignment->id, $fileName, 'local');

        // Check for existing submission (replace if exists)
        $existing = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', Auth::id())
            ->first();

        if ($existing) {
            // Delete old file
            Storage::disk('local')->delete($existing->file_path);

            // Update existing submission
            $existing->update([
                'file_path'    => $filePath,
                'file_name'    => $file->getClientOriginalName(),
                'submitted_at' => now(),
            ]);
        } else {
            // Create new submission
            Submission::create([
                'assignment_id' => $assignment->id,
                'student_id'    => Auth::id(),
                'file_path'     => $filePath,
                'file_name'     => $file->getClientOriginalName(),
                'submitted_at'  => now(),
            ]);
        }

        return redirect()->route('submissions.index')
            ->with('success', 'Assignment submitted successfully!');
    }
}