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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    $api->group(['prefix'=>'master'],function ($api){
        //登陆
        $api->post('/login','MasterController@login')
            ->name('v1.master.login');
        //退出
        $api->get('/logout','MasterController@logout')
            ->name('v1.master.logout');
        //显示个人信息
        $api->get('/users/{id}','MasterController@show')
            ->name('v1.master.users.show');
        //修改个人资料
        $api->put('/users/{id}','MasterController@save')
            ->name('v1.master.users.save');
        $api->get('/video','VideoController@show')
            ->name('v1.master.video.show');
//
    });

//    $api->group(['prefix'=>'master/video'],function ($api){
//        $api->get('?{params}','VideoController@show')
//            ->name('v1.master.video.show');
//    });
});
