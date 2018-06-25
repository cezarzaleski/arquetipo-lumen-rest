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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post(
    'v1/auth/login',
    [
        'uses' => 'AuthController@authenticate'
    ]
);
$router->get(
    'v1/users',
    [
        'uses' => 'UsersController@findAll'
    ]
);

//$router->group(
//    ['middleware' => 'jwt.auth'],
//    function () use ($router) {
//
//        $router->get(
//            'v1/users',
//            [
//                'uses' => 'UsersController@findAlls'
//            ]
//        );
//    }
//);
