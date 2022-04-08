<?php

namespace App\Http\Resources\ShoppingCart;

use App\Http\Resources\Product\ShortProductResource;
use App\Http\Resources\Variation\VariationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartResource extends JsonResource
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
            'shopping_cart_id' => $this->id,
            'quantity' => $this->quantity,
            'variation'  => new VariationResource($this->variation),
            'product' => new ShortProductResource($this->variation->product),
        ];
    }
}
