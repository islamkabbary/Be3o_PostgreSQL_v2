<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

class RegisterRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email'      => 'required|email|unique:users,email',
            'password'   => ['required', 'string', Password::min(6)->mixedCase()->numbers()],
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => __('messages.Email is required'),
            'email.email'       => __('messages.Email must be a valid email'),
            'email.unique'      => __('messages.Email already exists'),

            'password.required' => __('messages.Password is required'),
            'password.min'      => __('messages.Password must be at least 6 characters'),

            'first_name.required' => __('messages.First name is required'),
            'last_name.required'  => __('messages.Last name is required'),
        ];
    }
}
