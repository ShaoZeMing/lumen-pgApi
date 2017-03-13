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

$app->get('/', function () use ($app) {
    var_dump(app()->environment());
    return $app->version();

});

$app->get('test', function () use ($app) {
//    phpinfo();
//    dd();
    $results = app('db')->select("select *,ST_DistanceSphere(geom,ST_GeomFromText('point(116.340714 39.992727)',4326)) dist from tbl_point where ST_DistanceSphere(geom,ST_GeomFromText('point(116.340714 39.992727)',4326)) < 10000 order by ST_DistanceSphere(geom,ST_GeomFromText('point(116.340714 39.992727)',4326)) limit 10");
    var_dump($results);
    $client = new \Predis\Client();
    $client->append('foo', 'bar');
    return 'foo stored as ' . $client->get('foo');
});


$app->group(['prefix' => 'pg','namespace' => 'pgApi'], function () use ($app) {
    $app->get('searchGeom',[
        'as' => 'profile', 'uses' => 'PgsqlApiController@searchGeom'
    ]);
});

//['namespace' => 'Api']
//$app->get('profile', [
//    'as' => 'profile', 'uses' => 'UserController@showProfile'
//]);
//
//$app->group(['prefix' => 'admin'], function () use ($app) {
//    $app->get('users', function ()    {
//        // Matches The "/admin/users" URL
//    });
//});