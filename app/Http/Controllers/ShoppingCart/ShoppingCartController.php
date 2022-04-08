<?php

namespace App\Http\Controllers\ShoppingCart;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingCartRequest;
use App\Http\Resources\ShoppingCart\ShoppingCartResource;
use App\Models\ShoppingCart;
use App\Models\Variation;
use App\Utils\CodeResponse;
use Exception;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(ShoppingCartResource::collection(Auth::user()->user->shoppingCart));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ShoppingCartRequest
     * @param  Variation $variation
     * @return \Illuminate\Http\Response
     */
    public function store(ShoppingCartRequest $request, Variation $variation)
    {
        $user = Auth::user()->user;
        try {
            $exist = ShoppingCart::whereVariationId($variation->id)->whereUserId($user->id)->first();
            if (!$exist) {
                $user->shoppingCart()->create([
                    'variation_id' => $variation->id,
                    'quantity' => $request->quantity,
                ]);
            } else {
                $exist->update(['quantity' => $exist->quantity += $request->quantity]);
            }
            return $this->successfulResponse(CodeResponse::CREATED);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ShoppingCart $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        try {
            $shoppingCart->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
