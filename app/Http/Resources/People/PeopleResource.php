<?php

namespace App\Http\Resources\People;

use Illuminate\Http\Resources\Json\JsonResource;

class PeopleResource extends JsonResource
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
            'email' => $this->user->email,
            'address' => isset($this->user->addresses[0]) ? $this->user->addresses[0]->address : 'Sin direcciones registradas',
            'created_at' => $this->created_at,
        ];
    }
}
