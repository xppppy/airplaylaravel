<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\MasterRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class MasterController extends Controller
{
    //建立构造器，使用该类前先通过中间件，判断是否登陆。except为排除的路由地址
    public function __construct() {
        $this->middleware('auth',['except'=>['show','login','index']]);
    }

    //管理员登陆
    public function login(MasterRequest $request)
    {
        $credentials['account'] = "aa";
        $credentials['password'] = "aa";
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }
        try {
            return $this->response->array([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ])->setStatusCode(201);
        } catch (\ErrorException $e) {
            return $this->response->array(['msg' => $e]);
        }
//        return $this->response->array(['test_message' => 'store verification code']);
    }

    //管理员退出
    public function logout()
    {
        Auth::logout();
        return $this->response->array(['msg' => '成功']);
    }

    //显示所有管理员信息
    public function index()
    {
        return $this->response->array([
            "code" => 200,
            "msg" => '成功',
        ]);
    }

    //显示创建表单
    public function create()
    {

        return $this->response
            ->array([
                "code" => 200,
                "msg" => "成功",
            ]);
    }

//    //保存创建的数据
//    public function store()
//    {
//
//    }

    //显示对应id的内容
    public function show($id)
    {
        if ($id<=0){
            return;
        }
        $arr = Users::query()->find($id);
        return $arr;
    }

    //显示编辑表单
    public function edit($id)
    {
        if ($id<=0){
            return;
        }
        $arr = Users::query()->find($id);
        return $arr;
    }

    //保存编辑数据
    public function save()
    {

    }

    //删除
    public function destroy()
    {

    }
}
