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
    //主页
    $api->get('master/index', 'IndexController@index')
        ->name('v1.master.index');
    $api->post('master/login','MasterController@login')
        ->name('v1.master.login');
    $api->get('master/users/{id}','MasterController@show')
        ->name('v1.master.users.show');
});
