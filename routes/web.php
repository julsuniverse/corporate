<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/', 'IndexController', [
    'only' => ['index'],
    'names' => [
        'index' => 'home'
    ]
]);

Route::resource('portfolios', 'PortfolioController', [
    'parameters' => [
        'portfolios' => 'alias',
    ]
]);

Route::resource('articles', 'ArticleController', [
    'parameters' => [
        'articles' => 'alias',
    ]
]);

Route::get('articles/cat/{cat_alias?}', [
    'uses' => 'ArticleController@index',  'as' => 'articlesCat'
]);

Route::resource('comment', 'CommentController', [
    'only' => ['store']
]);

//Route::auth();
Auth::routes();

Route::get('login',  [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);

Route::post('login', 'Auth\LoginController@login');

Route::get('logout', 'Auth\LoginController@logout');

/**** ADMIN ****/

/*Route::group([
    'prefix' => 'admin',
    'middleware' => 'auth',
], function() {
    //admin
    Route::get('/', ['uses' => 'Admin\IndexController@index', 'as' => 'adminIndex']);
    Route::resource('/articles', 'Admin\ArticleController');

});*/

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', ['uses' => 'Admin\IndexController@index', 'as' => 'adminIndex'])
        ->middleware('can:VIEW_ADMIN');
    Route::resource('articles', 'Admin\ArticleController')->names([

    ]);
});


