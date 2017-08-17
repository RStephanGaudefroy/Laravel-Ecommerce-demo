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
Auth::routes();



Route::get('/', [
    'uses' => 'ProductController@getIndex',
    'as' => 'product.index'
]);



Route::group(['prefix' => 'user'], function() {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/profile', [
            'uses' => 'UserController@getProfile',
            'as' => 'user.profile'
        ]);  

        Route::get('/logout', [
            'uses' => 'UserController@getLogout',
            'as' => 'user.logout'
        ]);     
    });
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/paycard', [
        'uses' => 'ProductController@getPaycard',
        'as' => 'paycard',
    ]);

    Route::post('/paycard', [
        'uses' => 'ProductController@postPaycard',
        'as' => 'paycard',
    ]);

    Route::group(['prefix' => 'control'], function () {
        Route::get('/gestionArticle', 'ControlController@getGestionArticle')->name('control.gestionArticle');
        Route::get('/create', 'ControlController@getCreate')->name('control.create');
        Route::post('/postCreate', 'ControlController@postCreate')->name('control.postCreate');
        Route::get('/remove/{id}', 'ControlController@remove')->name('control.remove');
        Route::get('/update/{id}', 'ControlController@update')->name('control.update');
        Route::post('/postUpdate/{id}', 'ControlController@postUpdate') -> name('control.postUpdate');
    }); 

    /** 
    * @groupe de route derrière le controller ContactController
    * param : NomDuController@methodeDeController
    */
    Route::group(['prefix' => 'contact'], function () {
        Route::post('/postContact', 'ContactController@postContact') -> name('contact.postContact');
        Route::get('/pageContact', 'ContactController@pageContact') -> name('contact.pageContact');
    });   
});

Route::get('/addCart/{id}', [
    'uses' => 'ProductController@getAddCart',
    'as' => 'product.addCart'
]);

Route::get('/reduce/{id}', [
    'uses' => 'ProductController@getReduceByOne',
    'as' => 'product.reduceByOne'
]);

Route::get('/remove/{id}', [
    'uses' => 'ProductController@getRemove',
    'as' => 'product.remove'
]);

Route::get('/cartview', [
    'uses' => 'ProductController@getCart',
    'as' => 'product.cartview'
]);

