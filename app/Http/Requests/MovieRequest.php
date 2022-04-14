<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'director' => ['required', 'max:255'],
            'description' => ['required'],
            'trailer' => ['required', 'max:255'],
            'movie_length' => ['required', 'max:100'],
            'rated' => 'required',
            'movie_genre' => 'required|array',
            'cast' => 'required|array',
            'format' => 'required|array',
        ];
    }
}
