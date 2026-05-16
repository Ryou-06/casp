<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentAccountController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return \Illuminate\Support\Facades\Auth::user()->isTeacher()
            ? redirect()->route('teacher.dashboard')
            : redirect()->route('student.dashboard');
    })->name('dashboard');

    // Teacher routes
    Route::middleware(['role:teacher'])->group(function () {
        Route::get('/teacher/dashboard', [DashboardController::class, 'teacherDashboard'])->name('teacher.dashboard');
        Route::get('/students/create', [StudentAccountController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentAccountController::class, 'store'])->name('students.store');
        Route::post('/classrooms/{classroom}/students', [ClassroomController::class, 'addStudent'])->name('classrooms.students.store');
        Route::delete('/classrooms/{classroom}/students/{student}', [ClassroomController::class, 'removeStudent'])->name('classrooms.students.destroy');
        Route::resource('classrooms', ClassroomController::class);
        Route::resource('assignments', AssignmentController::class);
        
        // Teacher submission routes
        Route::get('/teacher/submissions/history', [SubmissionController::class, 'allSubmissionsHistory'])->name('teacher.submissions.history');
        Route::get('/teacher/submissions/{assignment}', [SubmissionController::class, 'showSubmissionsForTeacher'])->name('teacher.submissions');
        Route::get('/teacher/submission-files/{submission}/view', [SubmissionController::class, 'viewSubmissionFile'])->name('teacher.submissions.view');
        Route::get('/teacher/submission-files/{submission}/download', [SubmissionController::class, 'downloadSubmissionFile'])->name('teacher.submissions.download');
    });

    Route::get('/assignments/{assignment}/attachment', [AssignmentController::class, 'downloadAttachment'])
        ->name('assignments.attachment');

    // Student routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');
        Route::get('/student/classrooms', [ClassroomController::class, 'studentIndex'])->name('student.classrooms.index');
        Route::get('/student/classrooms/{classroom}', [ClassroomController::class, 'studentShow'])->name('student.classrooms.show');
        Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{assignment}', [SubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/submissions/{assignment}', [SubmissionController::class, 'store'])->name('submissions.store');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
