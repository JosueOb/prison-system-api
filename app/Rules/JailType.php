<?php

namespace App\Rules;

use App\Enums\JailTypeEnum;
use Illuminate\Contracts\Validation\Rule;

class JailType implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (JailTypeEnum::tryFrom($value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must match the following options: low, medium or high.';
    }
}
