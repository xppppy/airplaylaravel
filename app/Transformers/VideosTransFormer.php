<?php

namespace App\Transformers;

use App\Models\VideoModel;
use League\Fractal\TransformerAbstract;

class VideosTransFormer extends TransformerAbstract{
    public function transform(array $video) {
        if ($video){
            $aa = [];
            $i = 0;
            foreach ($video['data'] as $value){
                $aa[$i]['id'] = $value->id;
                $aa[$i]['title'] = $value->title;
                $aa[$i]['thum'] = $value->thum;
                $aa[$i]['sum'] = $value->sum;
                $aa[$i]['number'] = $value->number;
                $aa[$i]['hot'] = $value->hot;
                $aa[$i]['type'] = $value->type;
                $aa[$i]['playerUrl'] = $value->playerUrl;
//                $aa[$i]['created_at'] = $value->created_at;
//                $aa[$i]['updated_at'] = $value->updated_at;
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
        }else{
            return [
                'code'=>100,
                'msg'=>'内部错误',
                ];
        }


    }
}