<?php

namespace App\Http\Controllers\Api\Master;
//
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\EditMasterRequest;
use App\Http\Requests\Api\MasterRequest;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

/**
 * Class MasterController
 * @package App\Http\Controllers\Api\master
 */
class MasterController extends Controller {

    //建立构造器，使用该类前先通过中间件，判断是否登陆。except为排除的路由地址
    public function __construct() {
        $this->middleware('api.auth', ['except' => ['login']]);
    }

    /**
     * @param MasterRequest $request
     * @return mixed
     * @throws \ErrorException
     */
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
//              'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60*24*365
            ]
        ]);
    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    public function logout() {
        Auth::logout();
        return $this->response
            ->array([
                'code' => 200,
                'msg' => '成功'
            ]);
    }

    /**
     * @param int $id
     * @throws \ErrorException
     */
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

    /**
     * @param $id
     * @param EditMasterRequest $request
     * @param Users $user
     * @return mixed
     * @throws \ErrorException
     */
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

}
