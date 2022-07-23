<?php

namespace App\Http\Resources;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'birthdate' => $this->birthdate->toDateString(),
            'phone_number' => $this->phone_number,
            'home_phone_number' => $this->home_phone_number,
            'address' => $this->address,
            'avatar' => ImageHelper::getDiskImageUrl($this->getAvatarPath()),
            'role' => $this->role->name,
            'state' => $this->state,
        ];
    }
}
