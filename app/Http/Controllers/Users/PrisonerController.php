<?php

namespace App\Http\Controllers\Users;

use App\Enums\RoleEnum;

class PrisonerController extends UserController
{
    public function __construct()
    {
        $this->middleware('can:manage-prisoners');

        $role_slug = RoleEnum::PRISONER->value;
        parent::__construct(role_slug: $role_slug, can_receive_notifications: false);
    }
}
