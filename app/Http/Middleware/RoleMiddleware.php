<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * RoleMiddleware
 *
 * Checks that the authenticated user's role matches one of the allowed roles.
 * If not, redirects them to THEIR OWN dashboard instead of throwing a 403.
 *
 * Usage in routes:
 *   ->middleware(['auth', 'role:doctor'])
 *   ->middleware(['auth', 'role:admin,doctor'])
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $userRole = strtolower(trim((string) ($user->role ?? $user->user_type ?? 'patient')));

        // If user's role IS in the allowed list — let them through
        if (in_array($userRole, array_map('strtolower', $roles), true)) {
            return $next($request);
        }

        // BUG FIX: redirect to their own dashboard instead of 403
        // This prevents a doctor from getting a confusing 403 if they
        // accidentally hit a patient URL
        $dashboardUrl = match ($userRole) {
            'admin'   => '/admin/dashboard',
            'doctor'  => '/doctor/dashboard',
            'patient' => '/patient/dashboard',
            default   => '/patient/dashboard',
        };

        return redirect($dashboardUrl)->with('error',
            'You do not have permission to access that page.'
        );
    }
}