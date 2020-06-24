<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'nome'          => 'required|string', 
            'cognome'       => 'required|string', 
            'email'         => 'required|email|unique:users,email', 
            'password'              => [
                'required', 
                'between:8,32', 
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'confirmed'           // must be confirmed by the password_confirmation
            ], 
            'password_confirmation' => 'required|string|between:8,32'
        ];
    }
}
