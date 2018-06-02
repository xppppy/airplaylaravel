<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$app = app('Dingo\Api\Provider\LumenServiceProvider');
$api->version('v1', function ($api) {

});
//$app->register('Dingo\Api\Provider\LumenServiceProvider');
//
//$api->version('v1', function ($api) {
//    $api->resource('users', 'UserController');
//});