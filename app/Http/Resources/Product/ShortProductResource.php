<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\SubCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortProductResource extends JsonResource
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
            'name' => $this->name,
            'picture_url' => $this->picture,
            'sub_category' => $this->sub_category_id,
        ];
    }
}
