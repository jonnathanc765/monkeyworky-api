<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'picture_url' => $this->picture_url,
            'subcategories' => ShortSubCategoryResource::collection($this->subCategories()->orderBy('updated_at', 'DESC')->get())
        ];
    }
}
