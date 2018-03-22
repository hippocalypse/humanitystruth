<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use App\Rules\Recaptcha;

class RegistrationForm extends FormRequest
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
            "email" => "required|email",
            "phone" => "number", //minimum 10 digits?
            "password" => "required|confirmed",
            'g-recaptcha-response' => ['required', new Recaptcha],
        ];
    }
    
    public function persist()
    {
        $user = User::create(
            $this->only(['email', 'phone', 'password'])
        );
        
        //auth()->login($user);
        
        Mail::to($user)->send(new EmailVerification($user));
    }
}
