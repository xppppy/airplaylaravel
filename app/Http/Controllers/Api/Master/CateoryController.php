<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\CateoryRequest;
use App\Models\VideoTypeModel;
use Illuminate\Http\Request;
use Validator;

/**
 * Class CateoryController
 * @package App\Http\Controllers\Api\master
 * @extends
 */
class CateoryController extends Controller {

    /**
     * 新增分类管理
     * @param CateoryRequest          $request   通过CateoryRequest进行验证
     * @param VideoTypeModel          $model     注入VideoTypeModel模型
     * @return mixed
     * @throws \ErrorException
     */
    public function store(CateoryRequest $request , VideoTypeModel $model) {

            $model->fill($request->all());

            $model->type = $request->name;

            $bool = $model->save();

            return $bool==1 ?
                   $this->response->array(['code'=>200,'msg'=>'成功']):
                   $this->response->array(['code'=>100,'msg'=>'请勿重复提交']);
    }

    /**
     * 修改对应的分类
     * @param Request $request
     * @throws \ErrorException
     */
    public function save(Request $request) {

        $bool = DB::table('type')
            ->where('id',$request->id)
            ->update($request->all());

        return $bool == 1 ?
            $this->response->array(['code'=>200,'msg'=>'成功']):
            $this->response->errorUnauthorized('请勿重复提交');
    }

    /**
     * 删除
     * @param Request $request
     * @return array
     * @throws \ErrorException
     */
    public function destroy(Request $request) {

        $array = $request->all();

        $bool = DB::table('type')->whereIn('id',$array['id'])->delete();

        return $bool ==1 ?
            $this->response->array(['code'=>200,'msg'=>'成功']):
            $this->response->array(['code'=>100,'msg'=>'操作失败']);
    }

}
