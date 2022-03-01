<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_category' => 'required',
            'price' => 'required',
            'product_title' => 'required|unique:products',
            'quantity' => 'required',
            'description' => 'required',
            'additional_info' => 'required',
            'shipping_and_return_condition' => 'required',
            'product_preview_image' => 'required|mimes:jpg,jpeg,png|max:2048',
            // 'product_thumbnail' => 'required|mimes:jpg,jpeg,png|max:2048'
        ];
    }
  
}
