<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    use HandlesAuthorization;

    /* Determine whether the user can view any models */
    public function viewAny(User $user): bool
    {
        return $user->role->slug === RoleEnum::GUARD->value;
    }

    /* Determine whether the user can view the model */
    public function view(User $user, Report $report): Response
    {
        return $user->id === $report->user_id
            ? Response::allow()
            : Response::deny("You don't own this report.");
    }

    /* Determine whether the user can create models */
    public function create(User $user): bool
    {
        return $user->role->slug === RoleEnum::GUARD->value;
    }

    /* Determine whether the user can update the model */
    public function update(User $user, Report $report): Response
    {
        return $user->id === $report->user_id
            ? Response::allow()
            : Response::deny("You don't own this report.");
    }

    /* Determine whether the user can delete the model */
    public function delete(User $user, Report $report): Response
    {
        return $user->id === $report->user_id
            ? Response::allow()
            : Response::deny("You don't own this report.");
    }
}
