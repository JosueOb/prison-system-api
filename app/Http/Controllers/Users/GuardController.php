<?php

namespace App\Http\Controllers\Users;


use App\Enums\RoleEnum;

class GuardController extends UserController
{
    public function __construct()
    {
        $this->middleware('can:manage-guards');

        $role_slug = RoleEnum::GUARD->value;
        parent::__construct($role_slug);
    }
}
