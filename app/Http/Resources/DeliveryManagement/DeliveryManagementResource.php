<?php

namespace App\Http\Resources\DeliveryManagement;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryManagementResource extends JsonResource
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
            'delivery_management_id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'icon_active' => $this->icon_active,
        ];
    }
}
