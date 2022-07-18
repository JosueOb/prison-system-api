<?php

namespace App\Http\Controllers\Spaces;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spaces\JailRequest;
use App\Http\Resources\{JailResource, SpaceResource};
use App\Models\Jail;
use Illuminate\Http\JsonResponse;

class JailController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-jails');
    }

    public function index(): JsonResponse
    {
        $jails = Jail::orderBy('name', 'asc')->get();
        return $this->sendResponse(message: 'Jail list generated successfully', result: [
            'jails' => SpaceResource::collection($jails)
        ]);
    }

    public function store(JailRequest $request): JsonResponse
    {
        $jail_data = $request->validated();
        Jail::create($jail_data);
        return $this->sendResponse(message: 'Jail stored successfully');
    }

    public function show(Jail $jail): JsonResponse
    {
        return $this->sendResponse(message: 'Jail details', result: [
            'jail' => new JailResource($jail)
        ]);
    }

    public function update(JailRequest $request, Jail $jail): JsonResponse
    {
        $jail_data = $request->validated();
        $jail->fill($jail_data)->save();
        return $this->sendResponse(message: 'Jail updated successfully');
    }

    public function destroy(Jail $jail): JsonResponse
    {
        $jail_state = $jail->state;
        $message = $jail_state ? 'inactivated' : 'activated';

        if ($jail->users->isNotEmpty()) {
            return $this->sendResponse(message: 'This jail has assigned prisoner(s)', code: 403);
        }

        $jail->forceFill(['state' => !$jail_state])->save();

        return $this->sendResponse(message: "Jail $message successfully");
    }
}
