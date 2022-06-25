<?php

namespace App\Http\Controllers\Users;


use App\Enums\RoleEnum;
use App\Models\Role;

class DirectorController extends UserController
{
    public function __construct()
    {
        $role_slug = RoleEnum::DIRECTOR->value;

        $this->middleware('can:manage-directors');
        $this->middleware("verify.user.role:$role_slug")
            ->only('show', 'update', 'destroy');

        $director_role = Role::where('slug', $role_slug)->first();
        parent::__construct($director_role);
    }
}
