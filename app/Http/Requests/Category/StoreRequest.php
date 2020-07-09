<?php

namespace App\Http\Requests\Category;

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
            'name' => [
                'required',
                'min:3',
                Rule::unique('categories')->ignore($this->id)
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'name.min' => 'Please input more than 3 character',
            'name.unique' => 'Please input another name'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $error = $validator->errors()->first();
        throw new HttpResponseException(
            response()->json(array("error" => $error))
        );
    }
}
