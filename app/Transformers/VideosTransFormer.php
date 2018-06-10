<?php

namespace App\Transformers;

use App\Models\VideoModel;
use League\Fractal\TransformerAbstract;

class VideosTransFormer extends TransformerAbstract{
    public function transform(array $video) {
        if ($video){
            $aa = [];
            $i = 0;
            foreach ($video as $value){
                $aa[$i]['id'] =         $value[$i+1]['data']->id;
                $aa[$i]['title'] =      $value[$i+1]['data']->title;
                $aa[$i]['thum'] =       $value[$i+1]['data']->thum;
                $aa[$i]['sum'] =        $value[$i+1]['data']->sum;
                $aa[$i]['number'] =     $value[$i+1]['data']->number;
                $aa[$i]['hot'] =        $value[$i+1]['data']->hot;
                $aa[$i]['type'] =       $value[$i+1]['data']->type;
                $aa[$i]['playerUrl'] =  $value[$i+1]['data']->playerUrl;
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