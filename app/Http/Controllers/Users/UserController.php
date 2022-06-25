<?php

namespace App\Http\Controllers\Users;

use App\Helpers\PasswordHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateUserRequest, UpdateUserRequest};
use App\Http\Resources\{ProfileResource, UserResource};
use App\Models\{Role, User};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function index(): JsonResponse
    {
        $users = $this->role->users;

        return $this->sendResponse(message: 'User list generated successfully', result: [
            'users' => UserResource::collection($users),
        ]);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $user_data = $request->validated();
        $user = new User($user_data);
        $temp_password = PasswordHelper::generatePassword();
        $user->password = Hash::make($temp_password);
        $this->role->users()->save($user);

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
        $user_data = $request->validated();
        $user->fill($user_data);
        $user->save();

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
}
