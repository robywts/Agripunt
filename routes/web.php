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

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
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

    //users
    Route::get('users', ['as' => 'users', 'uses' => 'UserController@index']);
    Route::get('get-users', ['as' => 'users.data', 'uses' => 'UserController@getAllUsers']);
    Route::get('user/edit/{id}', ['as' => 'users.edit', 'uses' => 'UserController@editUsers']);
    Route::patch('user/edit/{id}', ['as' => 'users.update', 'uses' => 'UserController@updateUser']);
    Route::post('user/delete/{id}', ['as' => 'users.delete', 'uses' => 'UserController@destroyUser']);
    Route::get('user/create', ['as' => 'users.add', 'uses' => 'UserController@createUser']);
    Route::post('user/create', ['as' => 'users.store', 'uses' => 'UserController@storeUser']);
    
    //articles
    Route::get('articles', ['as' => 'articles', 'uses' => 'ArticleController@index']);
    Route::get('get-articles/{user_id}', ['as' => 'articles.data', 'uses' => 'ArticleController@getAllArticles']);
});
