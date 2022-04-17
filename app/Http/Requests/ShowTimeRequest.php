<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowTimeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'room_id' => ['required'],
            'movie_id' => ['required'],
            'day' => ['required'],
            'time_start' => ['required'],
            'time_end' => ['required'],
        ];
    }
}
