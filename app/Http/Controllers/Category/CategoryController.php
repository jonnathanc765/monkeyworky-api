<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Utils\ImageTrait;

use Exception;

class CategoryController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(CategoryResource::collection(Category::get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $category = Category::create([
                'name' => $request->name,
            ]);
            if ($request->hasFile('picture')) {
                $category->picture()->create([])->attach($request->picture);
            }
            $category->save();
            DB::commit();

            return $this->successfulResponse();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->name = $request->name;
            $category->update();
            if ($request->hasFile('picture')) {
                if ($category->picture) {
                    $category->picture->delete();
                }
                $category->picture()->create([])->attach($request->picture);
            }
            DB::commit();
            return $this->successfulResponse();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            if ($category->picture) {
                $category->picture->delete();
            }
            $category->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
