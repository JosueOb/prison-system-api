<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyUserRole
{
    public function handle(Request $request, Closure $next, string $role_slug)
    {
        $user = $request->route('user');

        if (!$user->hasRole($role_slug)) {
            return abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
