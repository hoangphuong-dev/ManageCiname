<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieGenreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
        ];
    }
}
