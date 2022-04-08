<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Models\LoginHistory;
use App\Models\People;
use App\Models\State;
use App\Utils\CodeResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $request['state_id'] = $request->state;
            $people = People::create($request->only('firstname', 'lastname', 'state_id'));
            $request['password'] = Hash::make($request->password);
            $user = $people->user()->create($request->only('password', 'email'));
            $user->assignRole(Role::findByName('customer'));
            DB::commit();
            return $this->successfulResponse(CodeResponse::CREATED);
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function signIn(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            try {
                $login = LoginHistory::create([
                    'user_id' => Auth::id(),
                    'ip' => $request->ip(),
                    'api_token' => $this->generateToken(),
                ]);
                return $this->showOne(new AuthResource($login));
            } catch (Exception $e) {
                return $e;
            }
        }
        return $this->errorResponse(CodeResponse::INVALID_CREDENTIALS, 422);
    }

    public function generateToken(): string
    {
        do {
            $token = Str::random(191);
            $duplicate = LoginHistory::where('api_token', $token)->first();
        } while ($duplicate);
        return $token;
    }

    public function checkToken()
    {
        return $this->showOne(new AuthResource(Auth::user()));
    }

    public function logOut()
    {
        try {
            Auth::user()->api_token = null;
            Auth::user()->saveOrFail();
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
