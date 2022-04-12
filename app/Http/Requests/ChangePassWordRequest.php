<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassWordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required',
            'password' => ['nullable', 'confirmed'],
        ];
    }
}
