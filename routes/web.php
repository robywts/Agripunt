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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/rss', 'HomeController@test');
Route::get('/art-user', function () {
    return view('welcome');
});
//     Route::group(['middleware' => 'auth'], function () {
//
//	   Route::resource('store/{}', 'StoreController');
//
//	   Route::resource('admin/{}', 'AdminController');
//
//       });

Route::group(['prefix' => 'web'], function ($id) {
    Route::get('rssfeed', ['as' => 'rssfeed', 'uses' => 'RssfeedController@getAllRssfeeds']);
    Route::get('rssfeed/{id}', ['as' => 'edit-rssfeed', 'uses' => 'RssfeedController@getRssfeedById']);
    Route::patch('rssfeed/{id}', ['as' => 'edit-rssfeed', 'uses' => 'RssfeedController@updateRssfeed']);
    Route::post('rssfeed', ['as' => 'add-rssfeed', 'uses' => 'RssfeedController@addRssfeed']);
});
