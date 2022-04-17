<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'row_number' => ['required'],
            'column_number' => ['required'],
            'format' => ['required'],
            'cinema_id' => ['required'],
            'seats' => ['required'],
        ];
    }
}
