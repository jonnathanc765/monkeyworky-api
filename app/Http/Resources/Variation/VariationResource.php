<?php

namespace App\Http\Resources\Variation;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'size' => $this->size->size,
            'size_id' => $this->size->id,
        ];
    }
}
