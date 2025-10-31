<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon_url' => $this->icon_url,
            'image_url' => $this->image_url,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'requires_verification' => $this->requires_verification,
            'allows_negotiation' => $this->allows_negotiation,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
