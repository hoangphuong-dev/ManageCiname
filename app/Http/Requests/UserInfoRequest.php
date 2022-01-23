<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
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
            'password' => 'nullable',
            'password_new' => 'required_with:password|confirmed',
            'image' => 'nullable',
            'image' => 'nullable',
            'email' => 'required',
            'name' => 'required',
            'name_kana' => 'nullable',
            'name_kana_given' => 'nullable',
            'degree_type' => 'nullable',
            'age_type' => 'nullable',
            'postal_code' => 'nullable',
            'birthday' => 'required',
            'full_age' => 'nullable',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'address_furigana' => 'nullable',
            'address_other_code' => 'nullable',
            'address_other' => 'nullable',
            'address_other_furigana' => 'nullable',
            'forte_majors' => 'nullable',
            'hobby' => 'nullable',
            'sports_cultural' => 'nullable',
            'health_status' => 'nullable',
            'health_detail' => 'nullable',
            'pr_myself' => 'nullable',
            'job_target' => 'nullable',
            'education' => 'nullable',
            'education_delete' => 'nullable|array',
            'experiences' => 'nullable|array',
            'experiences_delete' => 'nullable|array',
            'qualifications' => 'nullable|array',
            'qualifications_delete' => 'nullable|array',
        ];
    }
}
