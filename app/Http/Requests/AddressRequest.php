<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'parish' => 'required|exists:parishes,id',
            'address' => 'required|string|min:3|max:300',
            'comment' => 'required|string|min:3|max:300',
            'name' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'parish' => 'parroquia',
            'address' => 'dirección',
            'comment' => 'indicaciones de la dirección',
            'name' => 'nombre de dirección',
            'type' => 'num piso/oficina/apto',
        ];
    }
}
