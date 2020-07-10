<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

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
            'category_id' => 'required|integer|exists:categories',
            'supplier_id' => 'required|integer|exists:suppliers',
            'code' => 'required',
            'garage' => 'required',
            'image' => 'required | image',
            'buying_date' => 'required | date_format:M / d / Y',
            'expire_date' => 'date_format:M / d / Y',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'name.min' => 'Please input more than 3 character',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $error = $validator->errors()->first();
        throw new HttpResponseException(
            response()->json(array("error" => $error))
        );
    }
}
