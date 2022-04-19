<?php

namespace App\Http\Requests;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'movie_id' => ['required', Rule::exists(Movie::class, 'id')],
            'user_id' => ['required', Rule::exists(User::class, 'id')],
            'content' => ['required', 'string'],
            'parent_id' => 'required',
        ];
    }
}
