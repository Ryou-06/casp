<?php

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\User;

test('teacher can create a classroom', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);

    $response = $this->actingAs($teacher)->post(route('classrooms.store'), [
        'name' => 'Grade 10 - Rizal',
        'section' => 'Section A',
        'subject' => 'Mathematics',
        'description' => 'Morning class',
    ]);

    $response->assertRedirect(route('classrooms.index'));

    $this->assertDatabaseHas('classrooms', [
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
        'section' => 'Section A',
        'subject' => 'Mathematics',
    ]);
});

test('student cannot access classroom creation', function () {
    $student = User::factory()->create(['role' => 'student']);

    $response = $this->actingAs($student)->get(route('classrooms.create'));

    $response->assertForbidden();
});

test('teacher cannot edit another teachers classroom', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $otherTeacher = User::factory()->create(['role' => 'teacher']);
    $classroom = Classroom::create([
        'teacher_id' => $otherTeacher->id,
        'name' => 'Private Class',
    ]);

    $response = $this->actingAs($teacher)->put(route('classrooms.update', $classroom), [
        'name' => 'Changed Name',
    ]);

    $response->assertForbidden();
});

test('teacher can add a registered student to a classroom', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'student']);
    $classroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Grade 10 - Rizal',
    ]);

    $response = $this->actingAs($teacher)->post(route('classrooms.students.store', $classroom), [
        'student_id' => $student->id,
    ]);

    $response->assertRedirect(route('classrooms.show', $classroom));

    $this->assertDatabaseHas('classroom_student', [
        'classroom_id' => $classroom->id,
        'student_id' => $student->id,
    ]);
});

test('student only sees assignments from enrolled classrooms', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'student']);
    $enrolledClassroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Enrolled Class',
    ]);
    $otherClassroom = Classroom::create([
        'teacher_id' => $teacher->id,
        'name' => 'Other Class',
    ]);
    $enrolledClassroom->students()->attach($student->id);

    $visibleAssignment = Assignment::create([
        'teacher_id' => $teacher->id,
        'classroom_id' => $enrolledClassroom->id,
        'title' => 'Visible Activity',
        'description' => 'Visible instructions',
        'subject' => 'Math',
        'due_date' => now()->addDay(),
    ]);
    Assignment::create([
        'teacher_id' => $teacher->id,
        'classroom_id' => $otherClassroom->id,
        'title' => 'Hidden Activity',
        'description' => 'Hidden instructions',
        'subject' => 'Science',
        'due_date' => now()->addDay(),
    ]);

    $response = $this->actingAs($student)->get(route('submissions.index'));

    $response->assertOk();
    $response->assertSee($visibleAssignment->title);
    $response->assertDontSee('Hidden Activity');
});
