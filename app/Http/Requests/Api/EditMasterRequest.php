<?php

namespace App\Http\Requests\Api;
use Illuminate\Support\Facades\Auth;

class EditMasterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account' => 'required|string|between:2,25|unique:users,account,'.Auth::id(),
            'password' => 'required|string|min:2',
        ];
    }

    public function messages() {
        return [
            'account.required' => '账号不能为空',
            'account.string' => '不能有特殊符号',
            'account.between' => '账号不能小于2大于25',
            'account.unique' => '账号已经被注册',
            'password.required' => '密码不能为空',
            'password.string' => '不能有特殊符号',
            'password.min' => '密码不能小于2',
        ];
    }
}
