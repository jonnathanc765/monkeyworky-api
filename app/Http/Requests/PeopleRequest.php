<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class PeopleRequest extends FormRequest
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
            'state' => 'required|exists:states,id',
            'firstname' => ['required', 'max:120', new AlphaSpaceRule()],
            'lastname' => ['required', 'max:120', new AlphaSpaceRule()],
            'phone' => 'nullable|regex:/^[\d -]+\d$/|min:11|max:30'
        ];
    }

    public function attributes()
    {
        return [
            'state' => 'estado',
            'firstname' => 'nombre',
            'lastname' => 'apellido',
            'phone' => 'teléfono',
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'El formato del campo :attribute es inválido, formato de ejemplo (0412 550 0000, 04125500000, 0412-5500000)'
        ];
    }
}
