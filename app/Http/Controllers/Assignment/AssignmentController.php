<?php

namespace App\Http\Controllers\Assignment;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\{SpaceResource, UserResource};
use App\Models\{Role, User};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class AssignmentController extends Controller
{
    protected string $role_slug;
    protected Builder $space;
    protected int|null $capacity;

    public function __construct(string $role_slug, Builder $space, int|null $capacity = null)
    {
        $this->role_slug = $role_slug;
        $this->space = $space;
        $this->capacity = $capacity;
    }

    public function index(): JsonResponse
    {
        $role = Role::where('slug', $this->role_slug)->first();
        $users = $role->users;
        $spaces = $this->space->cursor()->filter(function ($model) {
            $total_users = $model->users->count();
            return (
                $this->capacity ? $this->capacity > $total_users : $model->capacity > $total_users
                ) && $model->state;
        })->all();

        return $this->sendResponse(message: 'Assignment list generated successfully', result: [
            'users' => UserResource::collection($users),
            'spaces' => SpaceResource::collection($spaces)
        ]);
    }

    public function assign(User $user, int $space): JsonResponse
    {
        $space = $this->space->findOrFail($space);

        if ($user->hasRole(RoleEnum::GUARD->value)) {
            $user_wards_id = $user->wards->modelKeys();
            $user->wards()->syncWithPivotValues($user_wards_id, ['state' => false]);
            $user->wards()->sync($space->id);
        } elseif ($user->hasRole(RoleEnum::PRISONER->value)) {
            $user_jails_id = $user->jails->modelKeys();
            $user->jails()->syncWithPivotValues($user_jails_id, ['state' => false]);
            $user->jails()->sync($space->id);
        }

        return $this->sendResponse(message: 'Assignment updated successfully', result: [
            'user' => new UserResource($user),
            'space' => $space
        ]);
    }
}
