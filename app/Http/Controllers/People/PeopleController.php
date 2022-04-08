<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\PeopleRequest;
use App\Http\Resources\People\PeopleResource;
use App\Models\People;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = People::query();

        if (Auth::user()->user->isCustomer()) {
            $response->whereHas('user.roles', fn ($query) => $query->where('name', 'admin'));
        } else {
            if ($request->role) {
                $response->whereHas('user.roles', fn ($query) => $query->where('name', $request->role));
            }
        }

        if ($request->search)
            $response->whereHas('user', fn ($query) => $query->where('email', 'LIKE', "%$request->search%"))->orWhere('phone', 'LIKE', "%$request->search%");
        return $this->showPaginated(PeopleResource::collection($response->paginate($request->limit)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PeopleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PeopleRequest $request)
    {
        DB::beginTransaction();
        try {

            $request['state_id'] = $request->state;
            Auth::user()->user->people()->update($request->only('state_id', 'firstname', 'lastname', 'phone'));
            DB::commit();
            return $this->successfulResponse();
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PeopleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(PasswordRequest $request)
    {
        try {
            Auth::user()->user()->update([
                'password' => Hash::make($request->password)
            ]);
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
