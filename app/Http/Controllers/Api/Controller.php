<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers\Api\master
 * 使用dingo的response  例如 $this->response->array($array);
 */
class Controller extends BaseController
{
    use Helpers;
}