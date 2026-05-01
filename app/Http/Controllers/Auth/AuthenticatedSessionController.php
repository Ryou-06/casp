<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get user before logout (for remember_token cleanup)
        $user = Auth::user();
        
        // Logout the user
        Auth::guard('web')->logout();

        // Invalidate the session (removes all session data)
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Clear the remember_token from database if "remember me" was used
        if ($user && $user->remember_token) {
            $user->setRememberToken(null);
            $user->save();
        }

        // Force clear the session cookie by setting expiration to past
        if ($request->hasCookie('laravel_session')) {
            cookie()->queue(cookie()->forget('laravel_session'));
        }

        return redirect('/');
    }
}
