<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowTimeRequest extends FormRequest
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
            'romm_id' => ['required'],
            'movie_id' => ['required'],
            'day' => ['required'],
            'time_start' => ['required'],
            'time_end' => ['required'],
        ];
    }
}
