<?php

namespace App\Http\Middleware\BelongsTo;

use App\Utils\ApiResponser;
use App\Utils\CodeResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageMiddleware
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
        if ($request->conversation) {
            if ($request->conversation->from_id == $user->id || $request->conversation->to_id == $user->id)
                return $next($request);
            else
                return $this->errorResponse(CodeResponse::FORBIDDEN, 403);
        }
    }
}
