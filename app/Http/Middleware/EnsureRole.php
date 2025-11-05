<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        if (!$user) return redirect()->guest(route('login'));
        $allowed = collect($roles)->flatten()->map(fn($r)=>trim($r))->filter();
        if ($allowed->isEmpty() || $allowed->contains($user->role)) return $next($request);
        abort(403, 'Unauthorized role');
    }
}
