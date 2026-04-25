<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if user has the required role
        if ($user->role !== $role) {
            // Log for debugging
            Log::warning('Role mismatch', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'required_role' => $role,
                'url' => $request->url()
            ]);

            abort(403, "Unauthorized. Required role: {$role}, Your role: {$user->role}");
        }

        return $next($request);
    }
}