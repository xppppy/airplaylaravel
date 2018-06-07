<?php

namespace App\Http\Controllers\Api\master;
//
use App\Http\Requests\Api\EditMasterRequest;
use App\Http\Requests\Api\MasterRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MasterController extends Controller {

    //建立构造器，使用该类前先通过中间件，判断是否登陆。except为排除的路由地址
    public function __construct() {
        $this->middleware('api.auth', ['except' => ['login']]);
    }

    //管理员登陆
    public function login(MasterRequest $request) {
        $credentials['account'] = $request->account;
        $credentials['password'] = $request->password;
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->array([
                'code'=>100,
                'msg'=>'用户名或密码错误']
            );
        }
        return $this->response->array([
            'code' => 200,
            'msg' => '成功',
            'result' => [
                'token' => $token,
              'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60*24*365
            ]
        ]);
    }

    //管理员退出
    public function logout() {
        Auth::logout();
        return $this->response
            ->array([
                'code' => 200,
                'msg' => '成功'
            ]);
    }

    //显示对应id的内容
    public function show($id = 0) {
        if ($id <= 0) {
            return;
        }
        $arr = Users::query()->find($id);
        if ($arr==null){
            return $this->response->array([
                'code'=>'100',
                'msg'=>'数据错误']);
        }
//        if ()
        return $this->response
            ->array([
                "code" => 200,
                "msg" => "成功",
                'result'=>$arr
            ]);
    }

    //保存编辑数据
    public function save($id,EditMasterRequest $request , Users $user) {

        $password = $request->password;
        $request['password'] = bcrypt($password);
        $currentUser = $user->find($id);
        $re = $currentUser->update($request->all());
        if ($re){
            return $this->response->array([
                'code'=>200,
                'msg'=>'修改成功'
            ]);
        }
    }

//    //显示所有管理员信息
//    public function index() {
//        return $this->response->array([
//            "code" => 200,
//            "msg" => '成功',
//        ]);
//    }
    //    //显示创建表单
//    public function create() {
//
//        return $this->response
//            ->array([
//                "code" => 200,
//                "msg" => "成功",
//            ]);
//    }

//    //显示编辑表单
//    public function edit($id) {
//        if ($id <= 0) {
//            return;
//        }
//        $arr = Users::query()->find($id);
//        return $arr;
//    }

//    //保存创建的数据
//    public function store() {
//
//    }



    public function destroy() {
    }


}
