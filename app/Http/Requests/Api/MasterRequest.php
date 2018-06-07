<?php

namespace App\Http\Requests\Api;

//管理员登陆验证
class MasterRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        dump($this->all());
        return [
            'account' => 'required|string',
            'password' => 'required|string|min:2',
        ];
    }

    public function messages() {
        return [
            'account.required' => '账号不能为空',
            'account.string' => '不能有特殊符号',
            'password.required' => '密码不能为空',
            'password.string' => '不能有特殊符号',
            'password.min' => '密码不能小于2',
        ];
    }

}
