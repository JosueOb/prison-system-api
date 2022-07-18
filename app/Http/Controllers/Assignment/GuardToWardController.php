<?php

namespace App\Http\Controllers\Assignment;

use App\Enums\RoleEnum;
use App\Models\Ward;

class GuardToWardController extends AssignmentController
{
    public function __construct()
    {
        $this->middleware('can:manage-assignment');
        $this->middleware('verify.ward.assignment')->only('assign');

        $role_slug = RoleEnum::GUARD->value;
        $space = Ward::query();
        $capacity = config('user.assignment.number_of_guards_per_ward');
        parent::__construct($role_slug, $space, $capacity);
    }
}
