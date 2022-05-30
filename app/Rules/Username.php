<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Username implements Rule
{
    private string $regular_expression = "/^(?=.*[a-z])[a-z\.\-\_\d)]+$/";

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
        return 'The :attribute may only contain lowercase letters, numbers, points,
        underscores and hyphens.';
    }
}
