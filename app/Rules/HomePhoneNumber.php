<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HomePhoneNumber implements Rule
{
    private string $regular_expression = "/(^(02)[0-9]{7})+$/";

    /**
     * Determine if the validation rule passes
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool)preg_match($this->regular_expression, $value);
    }

    /**
     * Get the validation error message
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute format is invalid.';
    }
}
