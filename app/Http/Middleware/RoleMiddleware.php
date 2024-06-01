<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect("/login");
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            abort(403, "Unauthorized");
        }
        
        return $next($request);
    }
}
