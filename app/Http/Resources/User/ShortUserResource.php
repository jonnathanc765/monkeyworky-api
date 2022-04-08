<?php

namespace App\Http\Resources\User;

use App\Http\Resources\People\PeopleShortResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortUserResource extends JsonResource
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
            'email' => $this->email,
            'people' => new PeopleShortResource($this->people),
        ];
    }
}
