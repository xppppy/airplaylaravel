<?php
/**
 * Created by PhpStorm.
 * User: Microsoft
 * Date: 2018/6/6
 * Time: 13:24
 */

namespace App\Transformers\Master;

use Illuminate\Pagination\Paginator;
use League\Fractal\TransformerAbstract;

class PageTransFormer extends Paginator{
    public function toArray(){
        return [
            'totle'=>'1',
        ];
    }
}