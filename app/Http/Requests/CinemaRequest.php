<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CinemaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'cinema_name' => ['required'],
            'address' => ['required'],
            'province_id' => ['required'],
        ];
    }
}
