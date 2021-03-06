<?php

namespace App\Http\Controllers\Users;

use App\Enums\RoleEnum;

class DirectorController extends UserController
{
    public function __construct()
    {
        $this->middleware('can:manage-directors');

        $role_slug = RoleEnum::DIRECTOR->value;
        parent::__construct($role_slug);
    }
}
