<?php

namespace App\Http\Requests\Product;

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
            'category_id' => 'required|integer|exists:categories,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'code' => 'required',
            'image' => 'sometimes | image',
            'buying_date' => 'required|date',
            'expire_date' => 'date',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'name.min' => 'Please input more than 3 character',
            'buying_date.date_format' => "Buying date format is wrong, Example: ".date("m/d/Y")
        ];
    }

    protected function failedValidation(Validator $validator) {
        $error = $validator->errors()->first();
        throw new HttpResponseException(
            response()->json(array("error" => $error))
        );
    }
}
