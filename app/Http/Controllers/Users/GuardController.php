<?php

namespace App\Http\Controllers\Users;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GuardController extends UserController
{
    public function __construct()
    {
        $this->middleware('can:manage-guards');

        $role_slug = RoleEnum::GUARD->value;
        parent::__construct($role_slug);
    }

    public function destroy(User $user): JsonResponse
    {
        $user_state = $user->state;
        $message = $user_state ? 'inactivated' : 'activated';

        if ($user_state) {
            $user_wards_id = $user->wards->modelKeys();
            $user->wards()->syncWithPivotValues($user_wards_id, ['state' => false]);
        }

        $user->state = !$user_state;
        $user->save();

        return $this->sendResponse(message: "User $message successfully");
    }
}
