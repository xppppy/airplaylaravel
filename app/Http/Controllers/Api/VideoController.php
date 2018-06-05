<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\VideoRequest;
use App\Models\VideoModel;
use App\Models\VideoTypeModel;
class VideoController extends Controller
{
//    //建立构造器，使用该类前先通过中间件，判断是否登陆。except为排除的路由地址
//    public function __construct() {
//        $this->middleware('api.auth', ['except' => ['login']]);
//    }
    //展示分页信息
    public function show(VideoRequest $request){
       $type = $request->type;
       $name = $request->name;
       $video = VideoModel::with('type')->paginate(2);
       $array = [];
       $array1=[];
       $a = 0;
       foreach ($video->items() as $item){
           $array[$a]['id']=$item->id;
           $array[$a]['title']=$item->title;
           $array[$a]['thum']=$item->thum;
           $array[$a]['sum']=$item->sum;
           $array[$a]['number']=$item->number;
           $array[$a]['playerUrl']=$item->playerUrl;
           $array[$a]['type']=$item->type->type;
           $a++;
           $array1 +=$array;
       }
       return $this->response->array([
           'code'=>200,
           'msg'=>'成功',
           'result'=>[
               'total'=>$video->total(),
               'data'=>$array1
           ]
       ]);
//        return ;
//        $video = VideoModel::with('type')->paginate(10);
//        return  $this->response->array([
//            'code'=>200
//        ]);
    }

    public function save(){

    }

//    public function
}
