<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\SubCategoryResource;
use App\Http\Resources\Variation\VariationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'variations' => VariationResource::collection($this->variations),
            'sub_category' => new SubCategoryResource($this->subCategory()->withTrashed()->first()),
        ];
    }
}
