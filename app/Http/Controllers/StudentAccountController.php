<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class StudentAccountController extends Controller
{
    public function create(): View
    {
        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get();

        return view('students.create', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/[A-Za-z]/', 'not_regex:/^\d+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'Student name must include letters and cannot be only numbers.',
            'name.not_regex' => 'Student name cannot be only numbers.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        return redirect()
            ->route('students.create')
            ->with('success', 'Student account created. Give these credentials to the student.')
            ->with('student_email', $validated['email'])
            ->with('student_password', $validated['password']);
    }
}
