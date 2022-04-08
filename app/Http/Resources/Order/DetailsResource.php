<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Address\AddressDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsResource extends JsonResource
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
            'order' => new OrderResource($this),
            'payment' => new PaymentResource($this->payment),
            'products' => ProductsResource::collection($this->products),
            'address' => isset($this->address) ? new AddressDetailsResource($this->address->address) : null,
        ];
    }
}
