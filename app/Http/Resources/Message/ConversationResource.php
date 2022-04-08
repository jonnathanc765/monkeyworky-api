<?php

namespace App\Http\Resources\Message;

use App\Http\Resources\People\PeopleShortResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'from' => new PeopleShortResource($this->from->people),
            'to' => new PeopleShortResource($this->to->people),
            'lastMessage' => (isset($this->messages[0])) ? $this->messages()->orderBy('id', 'DESC')->first() : ' ',
            'updated_at' => $this->updated_at,
        ];
    }
}
