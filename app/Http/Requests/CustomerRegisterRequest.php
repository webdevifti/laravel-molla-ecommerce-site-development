<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
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
            'customer_username' => 'required|string|max:255|unique:customers',
            'customer_email' => 'required|string|max:255|unique:customers',
            'password' => 'required|min:8',
            // 'category_image' => 'required|mimes:jpg,png,jpeg|max:2048',
        ];
    }

    public function messages(){
        return [
            'customer_username.required' => 'Username is required',
            'customer_username.unique' => 'Username already taken',
            'customer_email.unique' => 'Email already taken',
            'customer_email.required' => 'Email is required',
        ];
    }
}
