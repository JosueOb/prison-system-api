<?php

namespace App\Http\Controllers\Users;

use App\Helpers\PasswordHelper;
use App\Http\Controllers\Controller;
use App\Notifications\UserStoredNotification;
use App\Http\Requests\User\{CreateUserRequest, UpdateUserRequest};
use App\Http\Resources\{ProfileResource, UserResource};
use App\Models\{Role, User};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected string $role_slug;
    protected bool $can_receive_notifications;

    public function __construct(string $role_slug, bool $can_receive_notifications = true)
    {
        $this->middleware('is.user.active')->only('update');
        $this->middleware("verify.user.role:$role_slug")
            ->only('show', 'update', 'destroy');

        $this->role_slug = $role_slug;
        $this->can_receive_notifications = $can_receive_notifications;
    }

    public function index(): JsonResponse
    {
        $role = Role::where('slug', $this->role_slug)->first();
        $users = $role->users;

        return $this->sendResponse(message: 'User list generated successfully', result: [
            'users' => UserResource::collection($users),
        ]);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $user_data = $request->validated();
        $role = Role::where('slug', $this->role_slug)->first();
        $user = new User($user_data);
        $temp_password = PasswordHelper::generatePassword();
        $user->password = Hash::make($temp_password);
        $role->users()->save($user);

        if ($this->can_receive_notifications) {
            $this->sendNotifications($user, $temp_password);
        }

        return $this->sendResponse(message: 'User stored successfully');

    }

    public function show(User $user): JsonResponse
    {
        return $this->sendResponse(message: 'User profile', result: [
            'user' => new ProfileResource($user),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $old_user_email = $user->email;
        $user_data = $request->validated();
        $user->fill($user_data);
        $user->save();

        if ($this->can_receive_notifications && $old_user_email !== $user->email) {
            $temp_password = PasswordHelper::generatePassword();
            $user->password = Hash::make($temp_password);
            $user->save();

            $this->sendNotifications($user, $temp_password);
        }

        return $this->sendResponse(message: 'User updated successfully');
    }

    public function destroy(User $user): JsonResponse
    {
        $user_state = $user->state;
        $message = $user_state ? 'inactivated' : 'activated';
        $user->state = !$user_state;
        $user->save();

        return $this->sendResponse(message: "User $message successfully");
    }

    private function sendNotifications(User $user, string $temp_password): void
    {
        $user->notify(
            new UserStoredNotification(
                user_name: $user->getFullName(),
                role_name: $user->role->name,
                temp_password: $temp_password
            )
        );
    }
}
