<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address_id' => $this->id,
            'address' => $this->address,
            'comment' => $this->comment,
            'name' => $this->name,
            'type' => $this->type,
            'parish' => new ParishResource($this->parish),
        ];
    }
}
