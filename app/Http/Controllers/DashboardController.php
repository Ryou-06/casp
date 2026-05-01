<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
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

        $totalClassrooms = Classroom::where('teacher_id', $user->id)->count();
        $totalAssignments = Assignment::where('teacher_id', $user->id)->count();
        $totalStudents = User::where('role', 'student')
            ->whereHas('enrolledClassrooms', function ($query) use ($user) {
                $query->where('teacher_id', $user->id);
            })
            ->count();
        $totalSubmissions = Submission::whereHas('assignment', function($q) use ($user) {
            $q->where('teacher_id', $user->id);
        })->count();

        return view('dashboard.teacher', compact(
            'user',
            'totalClassrooms',
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

        $assignmentQuery = Assignment::whereHas('classroom.students', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });

        $classrooms = $user->enrolledClassrooms()
            ->with('teacher')
            ->withCount('assignments')
            ->orderBy('name')
            ->get();

        $totalClassrooms = $classrooms->count();
        $totalAssignments = (clone $assignmentQuery)->count();
        $completedSubmissions = Submission::where('student_id', $user->id)->count();
        $pendingAssignments = (clone $assignmentQuery)->whereDoesntHave('submissions', function($q) use ($user) {
            $q->where('student_id', $user->id);
        })->where('due_date', '>', now())->count();
        $recentAssignments = (clone $assignmentQuery)
            ->with('classroom')
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        return view('dashboard.student', compact(
            'user',
            'totalClassrooms',
            'totalAssignments',
            'completedSubmissions',
            'pendingAssignments',
            'recentAssignments',
            'classrooms'
        ));
    }
}
