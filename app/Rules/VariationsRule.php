<?php

namespace App\Rules;

use App\Models\VariationSize;
use Illuminate\Contracts\Validation\Rule;

class VariationsRule implements Rule
{

    private $text;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->text = '';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_array($value)) return false;

        $ids = array();
        foreach ($value as $row) :
            if (isset($row['size_id'])) {
                if (isset($row['price'])) {
                    array_push($ids, $row['size_id']);
                    if ($row['price'] == '') {
                        $this->text = 'El precio de la variación debe tener un valor válido';
                        return false;
                    }
                } else {
                    $this->text = 'El valor precio no debe estar vacío';
                    return false;
                }
            } else {
                $this->text = 'El valor tamaño no debe estar vacío';
                return false;
            }
        endforeach;
        $variations = VariationSize::whereIn('id', $ids)->get();

        return (count($variations) == count($ids));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ($this->text != '') ? $this->text :  'Debe ingresar una variación válida';
    }
}
