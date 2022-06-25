<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'username' => $this->username,
            'full_name' => $this->getFullName(),
            'email' => $this->email,
            'role' => $this->role->name,
            'state' => $this->state,
        ];
    }
}
