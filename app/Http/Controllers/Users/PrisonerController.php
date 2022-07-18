<?php

namespace App\Http\Controllers\Users;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class PrisonerController extends UserController
{
    public function __construct()
    {
        $this->middleware('can:manage-prisoners');

        $role_slug = RoleEnum::PRISONER->value;
        parent::__construct(role_slug: $role_slug, can_receive_notifications: false);
    }

    public function destroy(User $user): JsonResponse
    {
        $user_state = $user->state;
        $message = $user_state ? 'inactivated' : 'activated';

        if ($user_state) {
            $user_jails_id = $user->jails->modelKeys();
            $user->jails()->syncWithPivotValues($user_jails_id, ['state' => false]);
        }

        $user->state = !$user_state;
        $user->save();

        return $this->sendResponse(message: "User $message successfully");
    }
}
