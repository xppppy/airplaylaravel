<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Api\Controller;
use App\Transformers\VideosTransFormer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function index(Request $request){
        $type = $request->type;
        $name = $request->name;

        $response_arr = new VideosTransFormer();

        $sum = DB::table('type')->count();
        $aa = [];
        for ($i = 1 ; $i <= $sum; $i++){
            $arry =DB::table('video')
                ->leftJoin('type', 'video.type_id', '=', 'type.id')
                ->where('type_id', '=', $i)
                ->orderBy('hot','desc')
                ->select('video.*', 'type.type')
                ->paginate(5);
            $aa[$i-1] = $arry;
        }
        print_r($aa);
//            ->Join('type', 'video.type_id', '=', 'type.id')
//            ->groupBy('type_id')
//            ->having('type_id','>',5)
//            ->get()
        ;
//            ->when($name, function ($query) use ($name) {
//                return $query->where('video.title', 'like', '%' . $name . '%');
//            })
//            ->when($type, function ($query) use ($type) {
//                return $query->where('type.type', $type);
//            })
//            ->select('video.*', 'type.type')
//            ->paginate(5);
//        return $video ? $video:
////            $response_arr->transform(collect($video)->toArray()):
//            $this->response->array(['code'=>100,'msg'=>'操作失败']);
    }
    public function show(){}
    public function player(){}
    public function analysis(){}
}
