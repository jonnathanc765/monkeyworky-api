<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\User\ShortUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressDetailsResource extends JsonResource
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
            'user' => new ShortUserResource($this->user),
        ];
    }
}
