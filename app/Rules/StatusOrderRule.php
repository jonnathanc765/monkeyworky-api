<?php

namespace App\Rules;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StatusOrderRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Auth::user()->user;
        if ($user->isAdmin()) {
            return ($value == Order::REFUSED || $value == Order::PENDING_FOR_PAYMENT || $value == Order::APPROVED_PAYMENT || $value == Order::ON_HOLD || $value == Order::ON_THE_WAY || $value == Order::PENDING_BY_CUSTOMER || $value == Order::DELIVERED);
        }

        if ($user->isCustomer()) {
            return $value == Order::CANCELED;
        }
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El status introducido es incorrecto';
    }
}
