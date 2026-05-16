<?php

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('teacher can view and download a student submission file', function () {
    Storage::fake('public');

    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'student']);
    $classroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
        'subject' => 'Mathematics',
    ]);
    $assignment = Assignment::create([
        'teacher_id' => $teacher->id,
        'classroom_id' => $classroom->id,
        'title' => 'Activity Sheet',
        'description' => 'Complete the activity sheet.',
        'subject' => 'Mathematics',
        'due_date' => now()->addDay(),
    ]);

    Storage::disk('public')->put('submissions/activity.pdf', 'PDF content');

    $submission = Submission::create([
        'assignment_id' => $assignment->id,
        'student_id' => $student->id,
        'file_path' => 'submissions/activity.pdf',
        'file_name' => 'activity.pdf',
        'file_size' => 11,
        'submitted_at' => now(),
    ]);

    $this->actingAs($teacher)
        ->get(route('teacher.submissions.view', $submission))
        ->assertOk();

    $this->actingAs($teacher)
        ->get(route('teacher.submissions.download', $submission))
        ->assertOk()
        ->assertDownload('activity.pdf');
});

test('teacher cannot view another teachers submission file', function () {
    Storage::fake('public');

    $teacher = User::factory()->create(['role' => 'teacher']);
    $otherTeacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'student']);
    $classroom = Classroom::create([
        'teacher_id' => $otherTeacher->id,
        'name' => 'Grade 10 - Rizal',
        'subject' => 'Mathematics',
    ]);
    $assignment = Assignment::create([
        'teacher_id' => $otherTeacher->id,
        'classroom_id' => $classroom->id,
        'title' => 'Activity Sheet',
        'description' => 'Complete the activity sheet.',
        'subject' => 'Mathematics',
        'due_date' => now()->addDay(),
    ]);

    Storage::disk('public')->put('submissions/activity.pdf', 'PDF content');

    $submission = Submission::create([
        'assignment_id' => $assignment->id,
        'student_id' => $student->id,
        'file_path' => 'submissions/activity.pdf',
        'file_name' => 'activity.pdf',
        'file_size' => 11,
        'submitted_at' => now(),
    ]);

    $this->actingAs($teacher)
        ->get(route('teacher.submissions.view', $submission))
        ->assertForbidden();
});

test('student can submit html files', function () {
    Storage::fake('public');

    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'student']);
    $classroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
        'subject' => 'Web Development',
    ]);
    $classroom->students()->attach($student->id);

    $assignment = Assignment::create([
        'teacher_id' => $teacher->id,
        'classroom_id' => $classroom->id,
        'title' => 'HTML Activity',
        'description' => 'Submit your HTML file.',
        'subject' => 'Web Development',
        'due_date' => now()->addDay(),
    ]);

    $response = $this->actingAs($student)->post(route('submissions.store', $assignment), [
        'file' => UploadedFile::fake()->create('index.html', 4, 'text/html'),
    ]);

    $response->assertRedirect(route('student.classrooms.show', $classroom));

    $submission = Submission::where('assignment_id', $assignment->id)
        ->where('student_id', $student->id)
        ->first();

    expect($submission->file_name)->toBe('index.html');
    Storage::disk('public')->assertExists($submission->file_path);
});
