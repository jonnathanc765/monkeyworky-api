<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:200',
            'owner' => 'nullable|max:200',
            'email' => 'nullable|max:200|email',
            'phone' => 'nullable|regex:/^[\d -]+\d$/|min:11|max:30',
            'dni' => 'nullable|max:20|regex:/^[EeVvJjPp][- ][\d]+\d$/|',
            'account_number' => 'nullable|min:10|max:30|regex:/^[\d -]+\d$/',
            'type' => 'ends_with:USD,BS',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre del banco',
            'owner' => 'dueño de la cuenta',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
            'dni' => 'identificación',
            'account_number' => 'número de cuenta',
            'type' => 'tipo de moneda',
        ];
    }

    public function messages()
    {
        return [
            'dni.regex' => 'El formato del campo :attribute es inválido, formato de ejemplo (V-000000)',
            'phone.regex' => 'El formato del campo :attribute es inválido, formato de ejemplo (0412 550 0000, 04125500000, 0412-5500000)'
        ];
    }
}
