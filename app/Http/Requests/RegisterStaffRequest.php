<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterStaffRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')],
            'province_id' => ['required'],
            'cinema_id' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email này đã được sử dụng , Vui lòng dùng địa chỉ email khác !',
        ];
    }
}
