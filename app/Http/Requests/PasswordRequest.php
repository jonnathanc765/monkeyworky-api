<?php

namespace App\Http\Requests;

use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'original_password' => ['required', 'min:8', 'max:30', new PasswordRule()],
            'password' => 'required|min:8|max:30',
        ];
    }

    public function attributes()
    {
        return [
            'original_password' => 'La contraseña actual',
            'password' => 'La nueva contraseña',
        ];
    }
}
