<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalRegisterRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:100', 'unique:users'],
            'phone' => ['required', 'max:100'],
            'listImage' => ['required', 'array'],
            'listImage.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg'],
            'hospitalType' => ['required', 'exists:hospital_types,id'],
            'content' => []
        ];
    }
}
