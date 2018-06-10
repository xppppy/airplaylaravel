<?php
/**
 * Created by PhpStorm.
 * User: Microsoft
 * Date: 2018/6/9
 * Time: 14:06
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PublicVideoTransformer extends TransformerAbstract {
    public function transform($video) {
        $data = [];
        foreach ($video['data'] as $value) {
            $data[] = [
                'id'        => $value->id,
                'title'     => $value->title,
                'thum'      => $value->thum,
                'sum'       => $value->sum,
                'number'    => $value->number,
                'hot'       => $value->hot,
                'type'      => $value->type,
                'playerUrl' => $value->playerUrl,
                //               'created_at'= $value->created_at;
                //               'updated_at'= $value->updated_at;
            ];
        }

        return $data;
    }
}