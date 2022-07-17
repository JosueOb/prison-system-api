<?php

namespace App\Http\Controllers\Spaces;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spaces\WardRequest;
use App\Http\Resources\WardResource;
use App\Models\Ward;
use Illuminate\Http\JsonResponse;

class WardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-wards');
    }

    public function index(): JsonResponse
    {
        $wards = Ward::orderBy('name', 'asc')->get();
        return $this->sendResponse(message: 'Ward list generated successfully', result: [
            'wards' => $wards
        ]);
    }


    public function store(WardRequest $request): JsonResponse
    {
        $ward_data = $request->validated();
        Ward::create($ward_data);
        return $this->sendResponse(message: 'Ward stored successfully');
    }

    public function show(Ward $ward): JsonResponse
    {
        return $this->sendResponse(message: 'Ward details', result: [
            'ward' => new WardResource($ward)
        ]);
    }

    public function update(WardRequest $request, Ward $ward): JsonResponse
    {
        $ward_data = $request->validated();
        $ward->fill($ward_data)->save();
        return $this->sendResponse(message: 'Ward updated successfully');
    }

    public function destroy(Ward $ward): JsonResponse
    {
        $ward_state = $ward->state;
        $message = $ward_state ? 'inactivated' : 'activated';

        if ($ward->users->isNotEmpty()) {
            return $this->sendResponse(message: 'This ward has assigned guard(s)', code: 403);
        }

        $ward->forceFill(['state' => !$ward_state])->save();

        return $this->sendResponse(message: "Ward $message successfully");
    }
}
