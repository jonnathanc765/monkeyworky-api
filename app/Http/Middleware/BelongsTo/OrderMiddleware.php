<?php

namespace App\Http\Middleware\BelongsTo;

use App\Models\Order;
use App\Utils\ApiResponser;
use App\Utils\CodeResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderMiddleware
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user()->user;
        if ($request->method() == 'POST') {
            if ($user->people->phone == '') {
                return $this->errorResponse(CodeResponse::UNPROCESSABLE_DATA, 406);
            }
            if ($request->address != null) {
                return $user->addresses()->find($request->address) ?
                    $next($request) :
                    $this->errorResponse(CodeResponse::FORBIDDEN, 403);
            } else
                return $next($request);

            if ($request->order) {
                if (!$request->order->payment) {
                    return $request->order->user_id == $user->id ?
                        $next($request) :
                        $this->errorResponse(CodeResponse::FORBIDDEN, 403);
                }
                return $this->errorResponse(CodeResponse::DUPLICATE_ENTRY, 400);
            }
            return $this->errorResponse(CodeResponse::BAD_REQUEST, 400);
        }

        if ($request->order) {
            if ($user->isCustomer()) {

                if ($request->method() == 'PUT') {
                    if ($request->order->status != Order::PENDING_FOR_PAYMENT)
                        return $this->errorResponse(CodeResponse::BAD_REQUEST, 400);
                }

                return ($request->order->user_id == $user->id) ?
                    $next($request) :
                    $this->errorResponse(CodeResponse::FORBIDDEN, 403);
            }

            if ($user->isAdmin() && $request->method() == 'PUT') {
                if ($request->order->status == Order::CANCELED)
                    return $this->errorResponse(CodeResponse::BAD_REQUEST, 400);

                if ($request->order->status == Order::REFUSED)
                    return $this->errorResponse(CodeResponse::IS_CLOSED, 400);

                if ($request->order->status == Order::DELIVERED)
                    return $this->errorResponse(CodeResponse::IS_FINISH, 400);
            }
        }
        return $next($request);
    }
}
