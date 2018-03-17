<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Recaptcha implements Rule
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
    public final function passes($attribute, $value)
    {
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".env('RECAPTCHA_SECRET')."&response=".$value."&remoteip=".request()->ip());
        return json_decode($response,true)->success; //json_decode($response,true)['success'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The recaptcha validation failed.';
    }
}
