<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Helper\WrapperResponse;

class BaseRequest extends FormRequest
{
    // public function failedValidation(Validator $validator) {
    //     throw new HttpResponseException(WrapperResponse::toResponse($validator->errors(), 422));
    // }
}
