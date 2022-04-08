<?php

namespace App\Http\Middleware\BelongsTo;

use App\Utils\ApiResponser;
use App\Utils\CodeResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartMiddleware
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
        if ($request->shoppingCart) {
            if ($request->shoppingCart->user_id == Auth::user()->user->id)
                return $next($request);
            else
                return $this->errorResponse(CodeResponse::FORBIDDEN, 403);
        } else
            return $this->errorResponse(CodeResponse::DATA_NOT_FOUND, 404);
    }
}
