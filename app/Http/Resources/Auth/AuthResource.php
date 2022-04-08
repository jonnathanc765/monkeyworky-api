<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\People\PeopleShortResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'id' => $this->user->id,
            'email' => $this->user->email,
            'role' => $this->user->roles[0]->name,
            'api_token' => $this->api_token,
            'people' => new PeopleShortResource($this->user->people),
        ];
    }
}
