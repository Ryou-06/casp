<?php

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('teacher can add an optional file to an assignment', function () {
    Storage::fake('public');

    $teacher = User::factory()->create(['role' => 'teacher']);
    $classroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
        'subject' => 'Mathematics',
    ]);

    $response = $this->actingAs($teacher)->post(route('assignments.store'), [
        'classroom_id' => $classroom->id,
        'title' => 'Activity Sheet',
        'description' => 'Complete the attached activity sheet.',
        'subject' => 'Mathematics',
        'due_date' => now()->addDay()->format('Y-m-d H:i:s'),
        'attachment' => UploadedFile::fake()->create('activity.pdf', 128, 'application/pdf'),
    ]);

    $response->assertRedirect(route('classrooms.show', $classroom));

    $assignment = Assignment::where('title', 'Activity Sheet')->first();

    expect($assignment->attachment_name)->toBe('activity.pdf');
    Storage::disk('public')->assertExists($assignment->attachment_path);
});

test('teacher can attach html files to an assignment', function () {
    Storage::fake('public');

    $teacher = User::factory()->create(['role' => 'teacher']);
    $classroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
        'subject' => 'Web Development',
    ]);

    $response = $this->actingAs($teacher)->post(route('assignments.store'), [
        'classroom_id' => $classroom->id,
        'title' => 'HTML Starter',
        'description' => 'Use the attached HTML starter file.',
        'subject' => 'Web Development',
        'due_date' => now()->addDay()->format('Y-m-d H:i:s'),
        'attachment' => UploadedFile::fake()->create('index.html', 4, 'text/html'),
    ]);

    $response->assertRedirect(route('classrooms.show', $classroom));

    $assignment = Assignment::where('title', 'HTML Starter')->first();

    expect($assignment->attachment_name)->toBe('index.html');
    Storage::disk('public')->assertExists($assignment->attachment_path);
});

test('enrolled student can download assignment attachment', function () {
    Storage::fake('public');

    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'student']);
    $classroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
        'subject' => 'Mathematics',
    ]);
    $classroom->students()->attach($student->id);

    Storage::disk('public')->put('assignment-attachments/activity.pdf', 'PDF content');

    $assignment = Assignment::create([
        'teacher_id' => $teacher->id,
        'classroom_id' => $classroom->id,
        'title' => 'Activity Sheet',
        'description' => 'Complete the attached activity sheet.',
        'subject' => 'Mathematics',
        'due_date' => now()->addDay(),
        'attachment_path' => 'assignment-attachments/activity.pdf',
        'attachment_name' => 'activity.pdf',
        'attachment_size' => 11,
    ]);

    $response = $this->actingAs($student)->get(route('assignments.attachment', $assignment));

    $response->assertOk();
    $response->assertDownload('activity.pdf');
});

test('teacher cannot create assignment with past deadline', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $classroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
        'subject' => 'Mathematics',
    ]);

    $response = $this->actingAs($teacher)->post(route('assignments.store'), [
        'classroom_id' => $classroom->id,
        'title' => 'Late Activity',
        'description' => 'This deadline should not be accepted.',
        'subject' => 'Mathematics',
        'due_date' => now()->subDay()->format('Y-m-d H:i:s'),
    ]);

    $response->assertSessionHasErrors('due_date');
});

test('teacher cannot update assignment with past deadline', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
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

    $response = $this->actingAs($teacher)->patch(route('assignments.update', $assignment), [
        'classroom_id' => $classroom->id,
        'title' => 'Activity Sheet',
        'description' => 'Complete the activity sheet.',
        'subject' => 'Mathematics',
        'due_date' => now()->subDay()->format('Y-m-d H:i:s'),
    ]);

    $response->assertSessionHasErrors('due_date');
});
