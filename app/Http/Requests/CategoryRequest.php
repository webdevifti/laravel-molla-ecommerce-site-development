<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            // Validate Inputs
            'category_name' => 'required|string|max:255|unique:categories',
            'category_image' => 'required|mimes:jpg,png,jpeg|max:2048',
        ];
    }

    public function messages(){
        return [
            'category_name.required' => 'Category name is required',
           
        ];
    }
}
