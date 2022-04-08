<?php

namespace App\Http\Resources\Variation;

use App\Http\Resources\Product\ShortProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationDetailsResource extends JsonResource
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
            'product' => new ShortProductResource($this->product)
        ];
    }
}
