<?php

namespace App\Http\Resources\People;

use Illuminate\Http\Resources\Json\JsonResource;

class PeopleShortResource extends JsonResource
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
            'people_id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'state' => $this->state->name,
            'state_id' => $this->state->id,
        ];
    }
}
