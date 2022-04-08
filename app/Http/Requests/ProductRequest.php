<?php

namespace App\Http\Requests;

use App\Rules\VariationsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'sub_category' => 'required|exists:sub_categories,id',
            'variations' => ['required', 'array', new VariationsRule()],
            'name' => 'required|string|min:3|max:150',
            'picture' => [Rule::requiredIf($this->path() == 'api/product'), 'file'],
        ];
    }

    public function attributes()
    {
        return [
            'sub_category' => 'sub categoría',
            'variations' => 'variaciones',
            'name' => 'nombre del producto',
            'picture' => 'imagen del producto',
        ];
    }
}
