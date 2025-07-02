<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $value
     */
    public function passes($attribute, $value)
    {
        // todo review validation for phone number
        return preg_match('/^[0-9]*$/', trim($value))
            && strlen(trim($value)) >= 10
            && strlen(trim($value)) <= 20;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must only be numbers, with at least 10 digits. No decimals, dashes, or spaces.';
    }
}
