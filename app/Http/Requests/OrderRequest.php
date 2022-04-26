<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            // 'bank' => 'required|exists:banks,id',
            // 'type' => 'required|exists:delivery_management,id',
            // 'address' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            // 'type' => 'tipo de entrega',
            // 'address' => 'dirección',
            // 'bank' => 'banco',
        ];
    }
}
