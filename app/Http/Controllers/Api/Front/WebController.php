<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\TestController;
use App\Models\VideoModel;
use App\Models\VideoTypeModel;
use App\Transformers\Front\WebIndexVideosTransFormer;
use App\Transformers\PublicVideoTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    // 首页
    public function index(Request $request){

        $num = $request->num = 200 ;

        $response_arr = new WebIndexVideosTransFormer();

        //首先获取所有分类，拿到所有分类id，再video表类根据分类id查询数据
        $typeid = VideoTypeModel::all();
        $data = [];
        foreach ($typeid as $type){

            $vType = VideoTypeModel::find($type->id);
            // 获取该分类下五条最热门电影
            $data['hot'.$type->name] = VideoModel::with('type')->whereTypeId($vType->id)->orderBy('hot','desc')->limit($num)->get();

        }
        return [
            'code'=>200,
            'msg'=>'成功',
            'result'=>[
                'total'=>5,
                'data'=>$response_arr->transform($data)
            ]
        ];
    }

    //查询
    public function show(Request $request){

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

    //播放页
    public function player(Request $request,$idline = 100){

        $sourceaddr = $request->sourceaddr;
        $type = $request->type;
        $reptile = new TestController();
       $data = $reptile ->test($sourceaddr);
        dump($data);
    }

    //解析页
    public function analysis(){

        $playerUrl = [
            'vip线路一' => 'http://yun.baiyug.cn/vip/?url=',
            'vip线路二' => 'https://api.daidaitv.com/index/?url=',
        ];

        return [
            'code'=>200,
            'msg'=>'成功',
            'result'=>[
                "playerUrl"=>[
                    [
                        'name'=>'vip线路一',
                        'url'=>$playerUrl['vip线路一']
                    ],
                    [
                        'name'=>'vip线路一',
                        'url'=>$playerUrl['vip线路一'],
                    ]
                ]

            ]
        ];
    }
}
