<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaretakerProcessRequest extends FormRequest
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
            'job_id' => 'required',
            'caretaker_id' => 'required',
            'processId' => 'required',
            'jobApplyStatusId' => 'required',
            'status' => 'required'
        ];
    }
}
