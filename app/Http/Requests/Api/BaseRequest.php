<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
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


    protected function failedValidation(Validator $validator)
    {
        print_r(json_encode([
            'code' => 9100,
            'msg'  => $validator->errors()->first()
        ]));

        exit;
    }
}
