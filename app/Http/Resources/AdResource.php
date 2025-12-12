<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'price'       => $this->price,
            'currency'    => $this->currency,
            'condition'   => $this->condition,

            'location' => [
                'governorate' => $this->governorate,
                'city'        => $this->city,
                'area'        => $this->area,
                'latitude'    => $this->latitude,
                'longitude'   => $this->longitude,
            ],

            'images'      => AdImageResource::collection($this->images),

            'attributes'  => $this->attributes->map(function ($attr) {
                return [
                    'attribute_id' => $attr->attribute_id,
                    'value'        => $attr->final_value,
                ];
            }),
        ];
    }
}
