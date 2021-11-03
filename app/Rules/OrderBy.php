<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OrderBy implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return ( $value === 'asc' || $value === 'desc' );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute sólo puede contener los valores "asc" o "desc"';
    }
}