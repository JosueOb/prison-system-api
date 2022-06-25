<?php

namespace App\Http\Controllers\Users;


use App\Enums\RoleEnum;
use App\Models\Role;

class DirectorController extends UserController
{
    public function __construct()
    {
        $director_role = Role::where('name', RoleEnum::DIRECTOR->value)->first();
        parent::__construct($director_role);
    }
}
