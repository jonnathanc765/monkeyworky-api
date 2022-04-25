<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
            $date = new Carbon();
            $name = str_replace(' ', '-', $request->name);
            $category = Category::create([
                'name' => $request->name,
                'picture' => ($request->hasFile('picture')) ? $request->file('picture')->storeAs("categories", "$name-$date->timestamp.png", 'public') : null,
            ]);

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
            $date = new Carbon();
            $category->name = $request->name;
            if ($request->hasFile('picture')) {
                $name = str_replace(' ', '-', $request->name);
                $this->deleteImage($category->picture);
                $category->picture = $request->file('picture')->storeAs("categories", "$name-$date->timestamp.png", 'public');
            }

            $category->update();
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
            $category->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
