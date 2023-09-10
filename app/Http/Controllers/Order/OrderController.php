<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderPaymentRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\StatusOrderRequest;
use App\Http\Resources\Order\DetailsResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\TrackingResource;
use App\Models\Address;
use App\Models\Bank;
use App\Models\Order;
use App\Utils\CodeResponse;
use App\Utils\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user()->user;

        if ($user->isCustomer()) {
            $response = Order::where('user_id', $user->id);
        } else {
            $response = Order::query();
        }

        if ($request->status) {
            $response->whereStatus($request->status);
        }

        if ($request->id) {
            $response->whereId($request->id);
        }
        return $this->showPaginated(OrderResource::collection($response->orderBy('created_at', 'DESC')->paginate($request->limit)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrderRequest
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user()->user;
            $total = 0;
            $products = [];

            // $bank = Bank::find($request->bank);

            foreach ($user->shoppingCart as $row) :
                $total += $row->quantity * $row->variation->price;
                array_push($products, [
                    'variation_id' => $row->variation_id,
                    'quantity' => $row->quantity,
                    'price' => $row->variation->price,
                ]);
                $row->delete();
            endforeach;


            $order = $user->orders()->create([
                'type_id' => $request->type,
                'status' => Order::PENDING_FOR_PAYMENT,
                'total' => $total + ($total * 0.16),
                'total_bs' => 0,
            ]);

            if ($request->address != null) {
                $order->address()->create(['address_id' => $request->address]);
            }
            $order->products()->createMany($products);
            DB::commit();
            return $this->showOne(new DetailsResource($order));
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $this->showOne(new DetailsResource($order));
    }

    /**
     * Display the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function showTracking(Order $order)
    {
        return $this->showOne(new TrackingResource($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StatusOrderRequest  $request
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(StatusOrderRequest $request, Order $order)
    {
        try {
            $order->update($request->validated());
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrderPaymentRequest $request
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function addPayment(OrderPaymentRequest $request, Order $order)
    {
        DB::beginTransaction();
        try {
            /* It should be done like this so that it does not save the temporary file */
            $payment = $order->payment()->create([
                'bank_id' => $request->bank,
                'owner' => $request->owner,
                'destination' => $request->destination,
                'email' => $request->email,
                'date' => $request->date,
                'reference' => $request->reference,
            ]);
            if ($request->hasFile('voucher')) {
                $payment->voucher()->create([])->attach($request->voucher);
            }
            $order->update(['status' => Order::ADDED_PAYMENT]);
            DB::commit();
            return $this->showOne(new DetailsResource($order));
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
