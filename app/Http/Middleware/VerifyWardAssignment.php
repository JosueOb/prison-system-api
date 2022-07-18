<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Models\Ward;
use Closure;
use Illuminate\Http\Request;

class VerifyWardAssignment
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->route('user');
        $ward_id = $request->route('space');
        $ward = Ward::findOrFail($ward_id);
        $user_ward = $user->wards->first();

        if (!$user->state || !$user->hasRole(RoleEnum::GUARD->value) || !$ward->state) {
            return abort(403, 'This action is unauthorized.');
        }

        if ($user_ward && $user_ward->id === $ward->id) {
            return abort(403, 'The guard is already assigned to that ward.');
        }

        return $next($request);
    }
}
