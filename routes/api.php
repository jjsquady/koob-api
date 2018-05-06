<?php

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

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function ($router) {

    /** @var $router \Illuminate\Routing\Router */
    $router->group(['prefix' => 'auth'], function ($router) {
        /** @var $router \Illuminate\Routing\Router */
        $router->get('me', 'Api\AuthController@me')->name('auth.me');
        $router->get('refresh', 'Api\AuthController@refresh')->name('auth.refresh');
        $router->post('login', 'Api\AuthController@login')->name('auth.login');
        $router->post('logout', 'Api\AuthController@logout')->name('auth.logout');
    });

    $router->get('search', 'KoobApiController@index')->name('search');

    $router->resource('users', 'Api\UserController')->except(['index', 'create', 'edit']);
    $router->resource('books', 'Api\BookController')->except(['create', 'edit']);
    $router->resource('books/favorite', 'Api\BookFavoriteController')
           ->only(['update', 'destroy'])->parameter('favorite', 'book');
    $router->resource('books/list', 'Api\BookListController')
           ->only(['store', 'destroy'])->parameter('list', 'book');
    $router->resource('books/status', 'Api\BookStatusController')
           ->only(['update'])->parameter('status', 'book');

});