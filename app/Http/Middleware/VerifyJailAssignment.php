<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Models\Jail;
use Closure;
use Illuminate\Http\Request;

class VerifyJailAssignment
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->route('user');
        $jail_id = $request->route('space');
        $jail = Jail::findOrFail($jail_id);

        if (!$user->state || !$user->hasRole(RoleEnum::PRISONER->value) || !$jail->state) {
            return abort(403, 'This action is unauthorized.');
        }

        if ($user->jails->first()->id === $jail->id) {
            return abort(403, 'The prisoner is already assigned to that jail.');
        }

        return $next($request);
    }
}
