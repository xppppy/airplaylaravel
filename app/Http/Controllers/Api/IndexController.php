<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        $linelist = [
            "id"=>1,
            "name"=>"线路一"
        ];
        return $linelist;
    }
}
