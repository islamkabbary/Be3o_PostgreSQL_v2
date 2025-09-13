<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class AbstractFormRequest extends FormRequest
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

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->isEmptyRequest()) {
                $validator->errors()->add('general', __("messages.At least one field must be submitted."));
            }
        });
    }

    protected function isEmptyRequest()
    {
        $filtered = collect($this->all())->filter(function ($value) {
            return !is_null($value) && !(is_string($value) && trim($value) === '');
        });

        return $filtered->isEmpty();
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
    
        throw new HttpResponseException(
            response()->json([
                'status' => 0,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'data' => null
            ], 422, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With, Authorization, lang',
                'Access-Control-Allow-Credentials' => 'true',
            ])
        );
    }  
}
