<?php

namespace App\Http\Resources\Bank;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
            'bank_id' => $this->id,
            'name' => $this->name,
            'owner' => $this->owner,
            'email' => $this->email,
            'phone' => $this->phone,
            'dni' => $this->dni,
            'account_number' => $this->account_number,
            'type' => $this->type,
        ];
    }
}
