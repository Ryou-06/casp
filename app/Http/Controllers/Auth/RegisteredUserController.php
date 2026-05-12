<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    /**
     * Public self-registration is disabled for this school demo.
     * Student accounts are created by the teacher/admin.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('login')
            ->with('status', 'Student accounts are created by the teacher/admin. Please ask your teacher for your login credentials.');
    }

    /**
     * Block direct registration attempts so users cannot choose their own role.
     */
    public function store(): RedirectResponse
    {
        return redirect()->route('login')
            ->with('status', 'Registration is handled by the teacher/admin.');
    }
}
