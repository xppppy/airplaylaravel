<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\MasterRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{
    //管理员登陆
    public function login(MasterRequest $request){
        $credentials['account'] = "aa";
        $credentials['password'] = "aa";
//        dd(\Auth()->attempt($credentials));
//        dd(\Auth::guard('api'));
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
//        return $this->response->array(['test_message' => 'store verification code']);
    }

    //管理员退出
    public function logout(){

    }

    //显示所有管理员信息
    public function index(){

    }

    //显示创建表单
    public function create(){

    }

    //保存创建的数据
    public function store(){

    }

    //显示对应id的内容
    public function show(Users $user){
        return $user;
    }

    //显示编辑表单
    public function edit(){

    }

    //保存编辑数据
    public function save(){

    }

    //删除
    public function destroy(){

    }
}
