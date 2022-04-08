<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\Address\AddressResource;
use App\Models\Address;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(AddressResource::collection(Auth::user()->user->addresses));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        DB::beginTransaction();
        try {
            $request['parish_id'] = $request->parish;
            $address = Auth::user()->user->addresses()->firstOrCreate($request->only('parish_id', 'address', 'comment', 'name', 'type'));
            DB::commit();
            return $this->showOne(new AddressResource($address));
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        try {
            $address->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
