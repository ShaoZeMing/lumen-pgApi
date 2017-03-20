<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/



$app->group(['prefix' => 'lbs', 'namespace' => 'LbsApi','middleware' => 'auth'], function () use ($app) {

    //师傅路由
    $app->get('search-worker', [
        'as' => 'searchRepairman', 'uses' => 'WorkerApiController@search'
    ]);
    $app->post('insert-worker', [
        'as' => 'insertRepairman', 'uses' => 'WorkerApiController@insert'
    ]);
    $app->post('save-worker', [
        'as' => 'saveRepairman', 'uses' => 'WorkerApiController@save'
    ]);


    //工单路由
    $app->get('search-order', [
        'as' => 'searchOrder', 'uses' => 'OrderApiController@search'
    ]);
    $app->post('insert-order', [
        'as' => 'insertOrder', 'uses' => 'OrderApiController@insert'
    ]);
    $app->post('save-order', [
        'as' => 'saveOrder', 'uses' => 'OrderApiController@save'
    ]);

    //导入数据路由
    $app->get('sync-worker', [
        'as' => 'syncWorker', 'uses' => 'CopydataApiController@sync'
    ]);

//    $app->get('test-worker', [
//        'as' => 'syncWorker', 'uses' => 'CopydataApiController@insert'
//    ]);

});


//$app->get('/', function () use ($app) {
//
//    return md5(uniqid());
//    });
