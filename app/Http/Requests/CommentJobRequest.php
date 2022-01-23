<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentJobRequest extends FormRequest
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
            'favorable_interview' => 'nullable|numeric',
            'atmosphere_interview' => 'nullable|numeric',
            'content' => 'required',
        ];
    }
}
