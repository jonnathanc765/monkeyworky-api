<?php

namespace App\Http\Middleware\BelongsTo;

use App\Utils\ApiResponser;
use App\Utils\CodeResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressMiddleware
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
        if ($request->method() == 'DELETE') {
            if ($request->address) {
                return ($request->address->user->id == Auth::user()->user->id) ?
                    $next($request) :
                    $this->errorResponse(CodeResponse::FORBIDDEN, 403);
            }

            return $this->errorResponse(CodeResponse::BAD_REQUEST, 400);
        }
        return $next($request);
    }
}
