<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'user_id' => 'nullable',
            'name' => 'required',
            'hospital_name' => 'required',
            'images' => 'nullable',
            'address' => 'required',
            'nearest_station' => 'required',
            'map_station' => 'required',
            'advantages' => 'nullable',
            'wage_min' => 'required',
            'wage_max' => 'required',
            'annual_income_min' => 'required',
            'annual_income_max' => 'required',
            'type_of_work' => 'required',
            'working_hours' => 'required|array',
            'working_hours.*' => 'required',
            'holidays' => 'required|array',
            'holidays.*' => 'required',
            'number_annual_holidays' => 'required',
            'description' => 'required',
            'occupation' => 'required|array',
            'occupation.*' => 'required',
            'certificate' => 'required',
            'years_experience' => 'required',
            'skills' => 'required',
            'experience_priority' => 'required',
            'benefits' => 'required',
            'comapany_name' => 'required',
            'comapany_establishment' => 'required',
            'comapany_introduce' => 'required',
            'job_process' => 'required|array',
            'job_process.*' => 'required',
        ];
    }
}
