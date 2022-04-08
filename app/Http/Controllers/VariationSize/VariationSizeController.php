<?php

namespace App\Http\Controllers\VariationSize;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariationRequest;
use App\Http\Resources\Variation\VariationSizeResource;
use App\Models\VariationSize;
use App\Utils\CodeResponse;
use Exception;
use Illuminate\Support\Facades\DB;

class VariationSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(VariationSizeResource::collection(VariationSize::get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\VariationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariationRequest $request)
    {
        try {
            VariationSize::create($request->validated());
            DB::commit();
            return $this->successfulResponse(CodeResponse::CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\VariationRequest  $request
     * @param  VariationSize $variationSize
     * @return \Illuminate\Http\Response
     */
    public function update(VariationRequest $request, VariationSize $variationSize)
    {
        try {
            $variationSize->update($request->validated());
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  VariationSize $variationSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(VariationSize $variationSize)
    {
        try {
            $variationSize->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
