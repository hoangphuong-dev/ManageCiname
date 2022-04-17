<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatTypeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'image' => ['required'],
            'price' => ['required'],
        ];
    }
}
