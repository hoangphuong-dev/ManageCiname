<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:100'],
            'oldPassword' => ['required', Password::min(8)],
            'newPassword' => ['required', Password::min(8)],
            'confirmPassword' => ['required', Password::min(8), 'same:newPassword'],
        ];
    }
}
