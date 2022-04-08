<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaSpaceRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return preg_match('/^[\pL\s]+$/u', $value);
    }

    public function message()
    {
        return 'El campo sólo debe contener letras y espacios';
    }
}
