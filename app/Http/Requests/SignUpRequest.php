<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'email' => 'required|unique:users,email|max:200',
            'state' => 'required|exists:states,id',
            'password' => 'required|min:8',
            'firstname' => ['required', 'max:120', new AlphaSpaceRule()],
            'lastname' => ['required', 'max:120', new AlphaSpaceRule()],
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'correo',
            'state' => 'estado',
            'password' => 'contraseña',
            'firstname' => 'nombre',
            'lastname' => 'apellido',
        ];
    }
}
