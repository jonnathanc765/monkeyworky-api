<?php

namespace App\Http\Resources\Variation;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationSizeResource extends JsonResource
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
            'size' => $this->size,
        ];
    }
}
