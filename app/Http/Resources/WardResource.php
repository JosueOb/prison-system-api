<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'state' => $this->state,
            'created_at' => $this->created_at->toDateTimeString(),
            'guards' => UserResource::collection($this->users)
        ];
    }
}
