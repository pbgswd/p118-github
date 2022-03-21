<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/^[0-9]*$/', trim($value))
            && strlen(trim($value)) >= 10
            && strlen(trim($value)) <= 20;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must only be numbers, with at least 10 digits. No decimals, dashes, or spaces.';
    }
}
