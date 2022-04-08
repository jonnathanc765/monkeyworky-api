<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Bank\BankResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'owner' => $this->owner,
            'email' => $this->email,
            'destination' => $this->destination,
            'date' => $this->date,
            'voucher' => $this->voucher,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'bank' => new BankResource($this->bank()->withTrashed()->first()),
        ];
    }
}
