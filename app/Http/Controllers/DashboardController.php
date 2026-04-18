<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the teacher dashboard.
     */
    public function teacherDashboard()
    {
        $user = Auth::user();

        $totalAssignments = Assignment::where('teacher_id', $user->id)->count();
        $totalStudents = User::where('role', 'student')->count();
        $totalSubmissions = Submission::whereHas('assignment', function($q) use ($user) {
            $q->where('teacher_id', $user->id);
        })->count();

        return view('dashboard.teacher', compact(
            'user',
            'totalAssignments',
            'totalStudents',
            'totalSubmissions'
        ));
    }

    /**
     * Show the student dashboard.
     */
    public function studentDashboard()
    {
        $user = Auth::user();

        $totalAssignments = Assignment::count();
        $completedSubmissions = Submission::where('student_id', $user->id)->count();
        $pendingAssignments = Assignment::whereDoesntHave('submissions', function($q) use ($user) {
            $q->where('student_id', $user->id);
        })->where('due_date', '>', now())->count();

        return view('dashboard.student', compact(
            'user',
            'totalAssignments',
            'completedSubmissions',
            'pendingAssignments'
        ));
    }
}