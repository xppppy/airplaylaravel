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
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array'
], function($api) {
    //后台路由
    $api->group(['prefix'=>'master'],function ($api){

        //登陆
        $api->post('/login','MasterController@login')
            ->name('v1.master.login');
        //退出
        $api->get('/logout','MasterController@logout')
            ->name('v1.master.logout');

        //管理员操作----------------------------------------
        $api->group(['prefix'=>'users'],function ($api){
            //显示个人信息
            $api->get('/{id}','MasterController@show')
                ->name('v1.master.users.show');
            //修改个人资料
            $api->put('/{id}','MasterController@save')
                ->name('v1.master.users.save');
        });

        //影视管理----------------------------------------
        $api->group(['prefix'=>'/video'],function ($api){
            //显示影视信息分页
            $api->get('/','VideoController@index')
                ->name('v1.master.video.index');
            //显示对应影视详细信息
            $api->get('/{id}','VideoController@show')
                ->name('v1.master.video.show');
            //修改保存
            $api->put('/{id}','VideoController@save')
                ->name('v1.master.video.save');
            $api->delete('/{id}','VideoController@destroy')
                ->name('v1.master.video.destroy');

        });
        //新增影视
        $api->post('/','VideoController@store')
            ->name('v1.master.video.store');
    });


});
