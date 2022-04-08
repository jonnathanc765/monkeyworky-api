<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Http\Resources\Bank\BankResource;
use App\Models\Bank;
use App\Utils\CodeResponse;
use Exception;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(BankResource::collection(Bank::get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BankRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request)
    {
        try {
            Bank::create($request->validated());
            return $this->successfulResponse(CodeResponse::CREATED);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BankRequest  $request
     * @param  Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, Bank $bank)
    {
        try {
            $bank->update($request->validated());
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        try {
            $bank->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
