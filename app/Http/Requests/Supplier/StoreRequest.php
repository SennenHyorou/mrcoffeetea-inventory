<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                Rule::unique('suppliers')->ignore($this->id)
            ],
            'phone' => [
                'required',
                Rule::unique('suppliers')->ignore($this->id)
            ],
            'address' => 'required',
            'city' => 'required',
            'photo' => 'sometimes|image',
            'type' => 'required|integer',
            'shop_name' => 'required',
            'account_holder' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
            'bank_branch' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $error = $validator->errors()->first();
        throw new HttpResponseException(
            response()->json(array("error" => $error))
        );
    }
}
