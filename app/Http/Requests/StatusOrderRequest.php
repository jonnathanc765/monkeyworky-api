<?php

namespace App\Http\Requests;

use App\Rules\StatusOrderRule;
use Illuminate\Foundation\Http\FormRequest;

class StatusOrderRequest extends FormRequest
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
            'status' => ['required', new StatusOrderRule()]
        ];
    }

    public function attributes()
    {
        return [
            'status' => 'estado',
        ];
    }
}
