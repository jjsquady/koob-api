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


Route::group(['middleware' => 'api'], function ($router) {

    $router->get('search', 'KoobApiController@index');

    $router->group(['prefix' => 'auth'], function ($router) {
        /**
         * @var $router \Illuminate\Routing\Router
         */
        $router->get('me', 'Api\AuthController@me');
        $router->post('login', 'Api\AuthController@login');
        $router->post('logout', 'Api\AuthController@logout');
        $router->get('refresh', 'Api\AuthController@refresh');
    });

});
