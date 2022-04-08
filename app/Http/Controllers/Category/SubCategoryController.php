<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use App\Utils\CodeResponse;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = SubCategory::paginate($request->limit);
        return $this->showPaginated(SubCategoryResource::collection($response));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request, Category $category)
    {
        try {
            $category->subCategories()->create($request->validated());
            return $this->successfulResponse(CodeResponse::CREATED);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, SubCategory $subCategory)
    {
        try {
            $subCategory->update($request->validated());
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        try {
            $subCategory->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
