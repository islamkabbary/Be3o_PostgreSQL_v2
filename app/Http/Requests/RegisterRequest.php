<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

class RegisterRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'password'   => ['required', 'string', Password::min(6)->mixedCase()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => __('messages.name is required'),

            'email.required'    => __('messages.Email is required'),
            'email.email'       => __('messages.Email must be a valid email'),
            'email.unique'      => __('messages.Email already exists'),

            'password.required' => __('messages.Password is required'),
            'password.min'      => __('messages.Password must be at least 6 characters'),
        ];
    }
}
