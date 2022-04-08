<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'sub_category_id' => $this->id,
            'name' => $this->name,
            'category' => new ShortSubCategoryResource($this->category()->withTrashed()->first()),
        ];
    }
}
