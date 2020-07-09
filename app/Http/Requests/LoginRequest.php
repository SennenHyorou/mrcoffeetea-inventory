<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'email|required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Email is not valid!',
            'email.required' => 'email is required!',
            'password.required' => 'Password is required!'
        ];
    }

    protected function failedValidation(Validator $validator) {

        $error = $validator->errors()->first();
        throw new HttpResponseException(
            response()->json($error)
        );
    }
}
