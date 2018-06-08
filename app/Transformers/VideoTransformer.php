<?php

namespace App\Transformers;

use App\Models\VideoModel;
use League\Fractal\TransformerAbstract;

class VideoTransformer extends TransformerAbstract {
    public function transform(VideoModel $video) {
            return [
                'code'  =>200,
                'msg'   =>'成功',
                'result'=>[
                    'id'         => $video->id,
                    'title'      => $video->title,
                    'thum'       => $video->thum,
                    'sum'        => $video->sum,
                    'number'     => $video->number,
                    'playerUrl'  => $video->playerUrl,
                    'type'       => $video->type->type,
//                'created_at' => $video->created_at->toDateTimeString(),
//                'updated_at' => $video->updated_at->toDateTimeString(),
                ],
            ];
        }

}