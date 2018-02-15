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
        'portfolios' => 'portfolios',
    ]
]);

Route::resource('articles', 'ArticleController', [
    'parameters' => [
        'alias' => 'alias',
    ]
]);

Route::get('articles/cat/{cat_alias?}', [
    'uses' => 'ArticleController@index',  'as' => 'articlesCat'
]);

Route::resource('comment', 'CommentController', [
    'only' => ['store']
]);

Route::auth();
//Auth::routes();

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

Route::get('ckfinder/ckfinder.html',function(){
    return view('pink.ckfinder.ckfinder');
});

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [
        'uses' => 'Admin\IndexController@index',
        'as' => 'adminIndex'
    ])->middleware('can:VIEW_ADMIN');

    Route::get('articles', [
        'uses' => 'Admin\ArticleController@index',
        'as' => 'articles.index'
    ])->middleware('can:VIEW_ADMIN_ARTICLES');

    Route::get('articles/create', [
        'uses' => 'Admin\ArticleController@create',
        'as' => 'articles.create'
    ])->middleware('can:save,App\Article');

    Route::post('articles/store', [
        'uses' => 'Admin\ArticleController@store',
        'as' => 'articles.store'
    ])->middleware('can:save,App\Article');

    Route::get('articles/show/{alias}', [
        'uses' => 'Admin\ArticleController@show',
        'as' => 'articles.show'
    ]);

    Route::put('articles/update/{alias}', [
        'uses' => 'Admin\ArticleController@update',
        'as' => 'articles.update'
    ]);

    Route::get('articles/edit/{alias}', [
        'uses' => 'Admin\ArticleController@edit',
        'as' => 'articles.edit'
    ])->middleware('can:edit,App\Article');

    Route::delete('articles/destroy/{alias}', [
        'uses' => 'Admin\ArticleController@destroy',
        'as' => 'articles.destroy'
    ]);
});


