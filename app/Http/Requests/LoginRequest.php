<?php

namespace App\Http\Requests;

class LoginRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => __('messages.Email is required'),
            'email.email'       => __('messages.Email must be a valid email'),

            'password.required' => __('messages.Password is required'),
        ];
    }
}
