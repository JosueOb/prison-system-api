<?php

namespace App\Http\Resources;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => ImageHelper::getDiskImageUrl($this->getImagePath()),
            'state' => $this->state,
            'created_by' => new UserResource($this->user),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
