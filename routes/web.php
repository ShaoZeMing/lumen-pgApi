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



$app->group(['prefix' => 'pg', 'namespace' => 'pgApi'], function () use ($app) {

    //师傅路由
    $app->get('search-repairman', [
        'as' => 'searchRepairman', 'uses' => 'RepairmanApiController@search'
    ]);
    $app->get('insert-repairman', [
        'as' => 'insertRepairman', 'uses' => 'RepairmanApiController@insert'
    ]);
    $app->get('save-repairman', [
        'as' => 'saveRepairman', 'uses' => 'RepairmanApiController@save'
    ]);


    //工单路由
    $app->get('search-order', [
        'as' => 'searchOrder', 'uses' => 'OrderApiController@search'
    ]);
    $app->get('insert-order', [
        'as' => 'insertOrder', 'uses' => 'OrderApiController@insert'
    ]);
    $app->get('save-order', [
        'as' => 'saveOrder', 'uses' => 'OrderApiController@save'
    ]);
});

//['namespace' => 'Api']
$app->get('/', function () use ($app) {

    return md5(uniqid());
    });
//
//$app->group(['prefix' => 'admin'], function () use ($app) {
//    $app->get('users', function ()    {
//        // Matches The "/admin/users" URL
//    });
//});