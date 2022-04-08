<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ResetPasswordRequest;
use App\Utils\CodeResponse;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{

    public function forgotPassword(Request $request): JsonResponse
    {

        $status = Password::sendResetLink(['email' => $request->email]);

        if ($status !== Password::RESET_LINK_SENT) {
            return $this->errorResponse(CodeResponse::DATA_NOT_FOUND, 404);
        }
        return $this->successfulResponse();
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {

        $success = Password::Reset(['email' => $request->email, 'password' => $request->password, 'token' => $request->token], function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($success == Password::INVALID_TOKEN) {
            return $this->errorResponse(CodeResponse::INVALID_TOKEN, 401);
        }
        return $this->successfulResponse();
    }
}
