<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_reverse([
            'id' => $this->id,
            'message' => $this->message,
            'send_id' => $this->send_id,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ]);
    }
}
