<?php

use App\Models\User;

test('teacher can create a student account', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);

    $response = $this->actingAs($teacher)->post(route('students.store'), [
        'name' => 'Juan Dela Cruz',
        'email' => 'juan@example.com',
        'password' => 'student123',
        'password_confirmation' => 'student123',
    ]);

    $response->assertRedirect(route('students.create', absolute: false));

    $this->assertDatabaseHas('users', [
        'name' => 'Juan Dela Cruz',
        'email' => 'juan@example.com',
        'role' => 'student',
    ]);
});

test('student cannot create another student account', function () {
    $student = User::factory()->create(['role' => 'student']);

    $response = $this->actingAs($student)->get(route('students.create'));

    $response->assertForbidden();
});
