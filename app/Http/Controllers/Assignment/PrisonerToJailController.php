<?php

namespace App\Http\Controllers\Assignment;

use App\Enums\RoleEnum;
use App\Models\Jail;

class PrisonerToJailController extends AssignmentController
{
    public function __construct()
    {
        $this->middleware('can:manage-assignment');
        $this->middleware('verify.jail.assignment')->only('assign');

        $role_slug = RoleEnum::PRISONER->value;
        $space = Jail::query();
        parent::__construct($role_slug, $space);
    }
}
