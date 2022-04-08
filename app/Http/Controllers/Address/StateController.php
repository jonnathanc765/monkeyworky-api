<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Resources\Address\MunicipalityResource;
use App\Http\Resources\Address\StateResource;
use App\Models\Municipality;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(StateResource::collection(State::get()));
    }

    /**
     * Display the specified resource.
     *
     * @param  State $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        return $this->showAll(MunicipalityResource::collection($state->municipalities));
    }

    /**
     * Display the specified resource.
     *
     * @param  State $state
     * @return \Illuminate\Http\Response
     */
    public function showMunicipality(Municipality $municipality)
    {
        return $this->showAll(MunicipalityResource::collection($municipality->parishes));
    }
}
