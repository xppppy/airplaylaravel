<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator;

class VipplayerurlController extends Controller
{
//    public function store(Request $request , VideoTypeModel $model) {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|unique:type,type.type|max:255',
//        ]);
//        if (!$validator->fails()){
//            $model->fill($request->all());
//            $model->type = $request->name;
//            $bool = $model->save();
//            return $this->response->array(['code'=>200,'msg'=>'成功']);
//        }
//        return $this->response->array(['code'=>100,'msg'=>'请勿重复提交']);
//    }

    public function save(Request $request) {
        $bool = DB::table('vipplayerurl')
            ->where('id',$request->id)
            ->update($request->all());
        return $bool == 1 ?
            $this->response->array(['code'=>200,'msg'=>'成功']):
            $this->response->errorUnauthorized('请勿重复提交');
    }

    public function destroy(Request $request) {
        $array = $request->all();
        $bool = DB::table('vipplayerurl')->whereIn('id',$array['id'])->delete();
        return $bool ==1 ?
            $this->response->array(['code'=>200,'msg'=>'成功']):
            $this->response->errorUnauthorized('请勿重复提交或无此数据');
    }
}
