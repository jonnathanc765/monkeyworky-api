<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderPaymentRequest extends FormRequest
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
            'bank' => 'required|exists:banks,id',
            'owner' => 'required|string|min:5|max:150',
            'email' => 'required|string|max:150|email',
            'destination' => 'required|string|max:300',
            'date' => 'required|date',
            'voucher' => 'required|filled',
            'reference' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'bank' => 'banco',
            'owner' => 'titular de la cuenta',
            'email' => 'correo electrónico',
            'voucher' => 'comprobante de pago',
            'reference' => 'número de referencia',
            'date' => 'fecha de la transacción',
        ];
    }
}
