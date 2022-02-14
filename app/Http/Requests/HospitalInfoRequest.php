<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalInfoRequest extends FormRequest
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
            'image' => 'nullable|array',
            'image_new' => 'nullable|array',
            'image_delete' => 'nullable|array',
            'name' => 'required',
            'hospital_type_id' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'content' => 'required',
        ];
    }
}
