<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\ShortProductResource;
use App\Http\Resources\Variation\VariationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'quantity' => $this->quantity,
            'variation'  => new VariationResource($this->variation()->withTrashed()->first()),
            'product' => new ShortProductResource($this->variation()->withTrashed()->first()->product()->withTrashed()->first())
        ];
    }
}
