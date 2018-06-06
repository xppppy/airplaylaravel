<?php

namespace App\Transformers;

use App\Models\VideoModel;
use League\Fractal\TransformerAbstract;

class VideosTransFormer extends TransformerAbstract{
    public function transform(array $video) {
        $aa = [];
        $i = 0;
        foreach ($video['data'] as $value){
//            dump($aa[$i]['id'] = $value->id);
            $aa[$i]['id'] = $value->id;
            $aa[$i]['title'] = $value->title;
            $aa[$i]['thum'] = $value->thum;
            $aa[$i]['sum'] = $value->sum;
            $aa[$i]['number'] = $value->number;
            $aa[$i]['playerUrl'] = $value->playerUrl;
            $aa[$i]['created_at'] = $value->created_at;
            $aa[$i]['updated_at'] = $value->updated_at;
            $i++;
            $aa += $aa;
        }
        return [
            'code'=>200,
            'msg'=>'成功',
            'result'=>[
                'total'=>$video['total'],
                'data'=>$aa
            ]
        ];
//        return [
//            'code'=>200,
//            'msg'=>'成功',
//            'result'=>[
////                'total'=>$total,
//                'id'         => $video['data']->id,
//                'title'      => $video['data']->title,
//                'thum'       => $video['data']->thum,
//                'sum'        => $video['data']->sum,
//                'number'     => $video['data']->number,
//                'playerUrl'  => $video['data']->playerUrl,
//                'type'       => $video['data']->type->type,
//                'created_at' => $video['data']->created_at->toDateTimeString(),
//                'updated_at' => $video['data']->updated_at->toDateTimeString(),
//            ],
//        ];
    }
}