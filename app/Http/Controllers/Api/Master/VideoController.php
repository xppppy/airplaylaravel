<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\VideoRequest;
use App\Models\VideoModel;
use App\Transformers\PublicVideoTransformer;
use App\Transformers\VideoTransformer;
use App\Transformers\VideosTransFormer;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;

/**
 * Class VideoController
 * @package App\Http\Controllers\Api\master
 */
class VideoController extends Controller {
    /**
//     * 建立构造器，使用该类前先通过中间件，判断是否登陆。
//     */
//    public function __construct() {
//        $this->middleware('api.auth');
//    }

    /**
     * 显示查询影视信息
     * 默认显示分页查询信息，每页10条
     * @param Request $request 获取需查询字段type,name
     * @return array
     * @throws \ErrorException
     */
    public function index(Request $request) {

        $type = $request->type;
        $name = $request->name;

        $response_arr = new PublicVideoTransformer();

        $data = DB::table('video')
            ->join('type', 'video.type_id', '=', 'type.id')
            ->when($name, function ($query) use ($name) {
                return $query->where('video.title', 'like', '%' . $name . '%');
            })
            ->when($type, function ($query) use ($type) {
                return $query->where('type.type', $type);
            })
            ->select('video.*', 'type.type')
            ->paginate(10);

        return $data ?
                [
                'code'=>200,
                'msg'=>'成功',
                    'result'=>[
                        'total'=>$data['total'],
                        'data'=>$response_arr->transform(collect($data)->toArray())
                    ]
                ]:
                $this->response->array(['code'=>100,'msg'=>'操作失败']);
    }

    /**
     * 显示对应影视信息，用于修改，保存
     * @param $id //获取需展示的索引int
     * @return \Dingo\Api\Http\Response
     * @throws \ErrorException
     */
    public function show($id) {

        $video_array = VideoModel::with('type')->find($id);

        return $video_array ?
               $this->response->item($video_array, new VideoTransformer()):
               $this->response->array(['code'=>100,'msg'=>'操作失败']);
    }

    /**
     * 修改保存对应影视信息
     * @param VideoRequest $request 获取修改信息
     * @param $id
     * @throws \ErrorException
     * @return mixed
     */
    public function save(VideoRequest $request, $id) {

        $bool = DB::table('video')
            ->where('id', $request->id)
            ->update($request->all());

        return $bool == 1 ?
            $this->response->array(['code' => 200, 'msg' => '成功']) :
            $this->response->array(['code' => 100, 'msg' => '修改失败']);

    }

    /**
     * 批量删除数据
     * @param Request $request 获取前台传递的数组
     * @throws \ErrorException
     * @return mixed
     */
    public function destroy(Request $request) {

        $array = $request->all();

        $bool = DB::table('video')->whereIn('id', $array['id'])->delete();

        return $bool == 1 ?
            $this->response->array(['code' => 200, 'msg' => '成功']) :
            $this->response->array(['code' => 100, 'msg' => '修改失败']);
    }

    /**
     * 新增影视
     * @param Request $request 获取新增消息
     * @param VideoModel $model 引入模型
     * @return mixed
     * @throws \ErrorException
     */
    public function store(Request $request, VideoModel $model) {

        $validator = Validator::make($request->all(), [
            'playerUrl' => 'required|unique:video|max:255',
        ]);

        if (!$validator->fails()) {
            $model->fill($request->all());
            $bool = $model->save();
            return $this->response->array(['code' => 200, 'msg' => '成功']);
        }
        return $this->response->array(['code' => 100, 'msg' => '请勿重复提交']);
    }
}
