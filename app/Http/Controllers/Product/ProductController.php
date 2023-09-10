<?php

namespace App\Http\Controllers\Product;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    // use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = Product::query();

        if ($request->category)
            $response->whereHas('subCategory', fn ($query) => $query->where('category_id', $request->category));

        if ($request->subCategory)
            $response->whereSubCategoryId($request->subCategory);

        if ($request->name)
            $response->where(function (Builder $query) use ($request) {
                return $query->where('name', 'LIKE', "%$request->name%")->orWhereHas('subCategory', fn ($query2) => $query2->where('name', 'LIKE', "%$request->name%"))->orWhereHas('subCategory.category', fn ($query2) => $query2->where('name', 'LIKE', "%$request->name%"));
            });
        return $this->showPaginated(ProductResource::collection($response->paginate($request->limit)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $request->name,
                'sub_category_id' => $request->sub_category,
            ]);
            if ($request->hasFile('picture')) {
                $product->picture()->create([])->attach($request->picture);
            }

            foreach ($request->variations as $row) :
                $product->variations()->create([
                    'size_id' => $row['size_id'],
                    'price' => $row['price'],
                ]);
            endforeach;
            DB::commit();
            return $this->showOne(new ProductResource($product));
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $product->name = $request->name;
            $product->sub_category_id = $request->sub_category;

            if ($request->hasFile('picture')) {
                $product->picture->delete();
                $product->picture()->create([])->attach($request->picture);
            }

            $product->saveOrFail();
            $product->variations()->delete();
            foreach ($request->variations as $row) :
                $product->variations()->create([
                    'size_id' => $row['size_id'],
                    'price' => $row['price'],
                ]);
            endforeach;
            DB::commit();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            if ($product->picture) {
                $product->picture->delete();
            }
            $product->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
