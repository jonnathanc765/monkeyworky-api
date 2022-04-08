<?php

namespace App\Http\Controllers\DeliveryManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryManagementRequest;
use App\Http\Resources\DeliveryManagement\DeliveryManagementResource;
use App\Models\DeliveryManagement;
use App\Utils\CodeResponse;
use App\Utils\ImageTrait;
use Exception;

class DeliveryManagementController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(DeliveryManagementResource::collection(DeliveryManagement::get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DeliveryManagementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryManagementRequest $request)
    {
        try {
            DeliveryManagement::create([
                'name' => $request->name,
                'description' => $request->description,
                'icon' => ($request->hasFile('icon')) ? $request->file('icon')->storeAs("/icons-sky/icons", "$request->name.png", 'public') : null,
                'icon_active' => ($request->hasFile('icon_active')) ? $request->file('icon_active')->storeAs("/icons-sky/icons", "$request->name-active.png", 'public') : null,
            ]);
            return $this->successfulResponse(CodeResponse::CREATED);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DeliveryManagement $deliveryManagement
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryManagementRequest $request, DeliveryManagement $deliveryManagement)
    {
        try {
            $deliveryManagement->name = $request->name;
            $deliveryManagement->description = $request->description;
            if ($request->hasFile('icon')) {
                $this->deleteImage($deliveryManagement->icon);
                $deliveryManagement->icon = $request->file('icon')->storeAs("/icons-sky/icons", "$request->name.png", 'public');
            }
            if ($request->hasFile('icon_active')) {
                $this->deleteImage($deliveryManagement->icon_active);
                $deliveryManagement->icon_active = $request->file('icon_active')->storeAs("/icons-sky/icons", "$request->name-active.png", 'public');
            }
            $deliveryManagement->saveOrFail();
            return $this->successfulResponse(CodeResponse::CREATED);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeliveryManagement $deliveryManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryManagement $deliveryManagement)
    {
        try {
            $deliveryManagement->delete();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
