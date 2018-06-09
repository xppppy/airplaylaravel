<?php

namespace App\Transformers\Front;

use League\Fractal\TransformerAbstract;

class WebIndexVideosTransFormer extends TransformerAbstract {
    /**
     * @param $video
     * @return array
     */
    public function transform($video) {
        $data = [];
        foreach ($video as $k=>$v){
            foreach ($v as $value) {
                if ($k!='hot'){
                    $data[$k][] = [
                        'id' => $value->id,
                        'title' => $value->title,
                        'thum' => $value->thum,
                        'sum' => $value->sum,
                        'number' => $value->number,
                        'hot' => $value->hot,
                        'type' => $value->type->type,
                        'playerUrl' => $value->playerUrl,
                        //               'created_at'= $value->created_at;
                        //               'updated_at'= $value->updated_at;
                    ];
                }
            }
        }

        return $data;
    }
}