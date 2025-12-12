<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'image_url'     => $this->image_url 
                                ? Storage::disk('public')->url($this->image_url)
                                : null,

            'thumbnail_url' => $this->thumbnail_url 
                                ? Storage::disk('public')->url($this->thumbnail_url)
                                : null,

            'alt_text'      => $this->alt_text,
            'sort_order'    => $this->sort_order,
            'is_primary'    => (bool) $this->is_primary,

            'file_size'     => $this->file_size,
            'image_width'   => $this->image_width,
            'image_height'  => $this->image_height,

            'created_at'    => $this->created_at?->toDateTimeString(),
        ];
    }
}
