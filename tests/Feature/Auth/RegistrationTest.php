<?php

test('public registration redirects to login', function () {
    $response = $this->get('/register');

    $response->assertRedirect(route('login', absolute: false));
});

test('public users cannot self register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $this->assertDatabaseMissing('users', [
        'email' => 'test@example.com',
    ]);
    $response->assertRedirect(route('login', absolute: false));
});
