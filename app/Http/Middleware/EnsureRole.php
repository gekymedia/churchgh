<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnsureRole
 *
 * This middleware ensures that the authenticated user has one of the
 * permitted roles before allowing the request to proceed. If the user
 * does not have the required role, a 403 response is returned. Roles
 * should be provided as a pipe‑separated list when applying the
 * middleware, e.g. `->middleware('role:admin|pastor')`.
 */
class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles Pipe‑separated list of roles
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }
        $allowed = explode('|', $roles);
        if (!in_array($user->role, $allowed)) {
            abort(403);
        }
        return $next($request);
    }
}