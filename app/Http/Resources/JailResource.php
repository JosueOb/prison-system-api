<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JailResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'capacity' => $this->capacity,
            'state' => $this->state,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
            'ward' => $this->ward,
            'prisoners' => UserResource::collection($this->users),
        ];
    }
}
