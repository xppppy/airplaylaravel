<?php
/**
 * Created by PhpStorm.
 * User: Microsoft
 * Date: 2018/6/9
 * Time: 14:40
 */

namespace App\Transformers\Front;


use League\Fractal\TransformerAbstract;

class WebPlayTransformer extends TransformerAbstract {

    public function transform($video) {
        return [
            'code' => 200,
            'msg' => '成功',
            'data' => [
                'videoNumber' => $video->id,
                'defaultUrl' => $video->title,
                'dafaultNme' => $video->thum,
                'hot' => $video->sum,
                'videoBrief' => $video->number,
                'playerTal' => [
                    'Urls'=>$video->number,
                    'name'=>$video->number,
                ],
                'type' => $video->type->type,
//                'created_at' => $video->created_at->toDateTimeString(),
//                'updated_at' => $video->updated_at->toDateTimeString(),
            ],
        ];
    }
}