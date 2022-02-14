<?php

namespace App\Http\Requests;

use App\Rules\ReceiverRule;
use Illuminate\Foundation\Http\FormRequest;

class MakeNotificationRequest extends FormRequest
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
            'receiver_ids' => [new ReceiverRule(), 'array'],
            'title' => ['required'],
            'content' => ['required'],
            'schedule' => [],
            'isAllHospital' => ['required', 'boolean'],
            'isAllCaretaker' => ['required', 'boolean']
        ];
    }
}
