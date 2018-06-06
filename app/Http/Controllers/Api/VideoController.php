<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\VideoRequest;
use App\Models\VideoModel;
use App\Models\VideoTypeModel;
use App\Transformers\PageTransFormer;
use App\Transformers\VideoTransformer;
use App\Transformers\VideosTransFormer;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
//    //建立构造器，使用该类前先通过中间件，判断是否登陆。except为排除的路由地址
//    public function __construct() {
//        $this->middleware('api.auth', ['except' => ['login']]);
//    }
    //展示分页信息
    public function index(VideoRequest $request) {
        $type = $request->type ;
        $name = $request->name ;
        $currentPage = $request->page = 1;
        if ($name != null) {
            $video = DB::table('video')
                ->leftJoin('type', 'video.type_id', '=', 'type.id')
                ->where('video.title', '=', $name)
                ->select('video.*', 'type.type')
                ->paginate(10, ['*'], 'page', $currentPage);
            $i = new VideosTransFormer();
            return $i->transform(collect($video)->toArray());
        } else if ($type != null) {
            $video = DB::table('video')
                ->Join('type', 'video.type_id', '=', 'type.id')
                ->where('type.type', '=', $type)
                ->select('video.*', 'type.type')
                ->Paginate(10, ['*'], 'page', $currentPage);
            $i = new VideosTransFormer();
            return $i->transform(collect($video)->toArray());
        } else if ($name == null && $type == null){
            $video = VideoModel::with('type')
                ->Paginate(10, ['*'], 'page', $currentPage);
            $i = new VideosTransFormer();
            return $i->transform(collect($video)->toArray());
        }
//       }
//        $video =Db::table('video')
//            ->leftJoin('type','video.type_id','=','type.id')
//            ->select('video.*','type.type')
//            ->Paginate(10,['*'],'page',$currentPage);
//       return $video;
//        $video = VideoModel::all(['*'])->where('title','=',$name)->;
//            when($name,function ($query)use($name){
//                return $query->where('video.title','=',$name);
//            },function ($query)use($type){
//                return $query->where('type.type','=',$type);
//            });
//        return $video;
//        return $total;
//        $array = [];
//        foreach ($total as $i){
//            echo $i;
////            $v = new VideosTransFormer();
////            $array = $v->transform($item);
//        }
//       return $this->response->item($arra,new VideosTransFormer());
//        return $video;
    }
    //显示对应影视信息
    public function show( $id ){

        $video_array = VideoModel::with('type')->find($id);

       return $video_array ?
              $this->response->item($video_array,new VideoTransformer()):
              $this->response->errorUnauthorized('参数错误');

//        return $video_info($video_array);
//        if ($video_array){
//            return $this->response->array([
//                'code'=>200,
//                'msg'=>'成功',
//                $this->response->item($video_array,new VideoTransformer())
//            ]);
//        }
    }
    public function save(){

    }

//    public function
}
