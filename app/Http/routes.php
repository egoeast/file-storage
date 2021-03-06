<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/test/{id}', 'FileStorageController@test');

Route::get('/index','FileStorageController@index');

Route::post('/storage/upload','FileStorageController@uploadFile');

Route::get('/send', 'FileStorageController@sendM');

Route::get('/download/{id}', 'FileStorageController@download');

Route::get('/public_download/{id}', 'FileStorageController@publicDownload');

Route::post('/mkdir', 'FileStorageController@makeDir');

Route::get('/storage/move/{id}','FileStorageController@quickMove');

Route::get('/storage/{id}','FileStorageController@showFolder');

Route::get('/delete/{id}','FileStorageController@delete');

Route::get('/share/{id}','FileStorageController@makePublicLink');

Route::get('/public_link/{id}','FileStorageController@share');

Route::get('/search', 'FileStorageController@search');

Route::post('/rename/{id}','FileStorageController@rename');

Route::resource('users', 'UserController');

Route::get('/users/delete/{id}', 'UserController@delete');

Route::get('/activation/{code}', 'UserController@activation');

Route::get('/file/{id}',function($id){
    $file = \App\UserFile::find($id);

    return Response::json($file);
});

Route::get('/test', function(){
    return view('test');
});

Route::get('set-lang/{id}', ['as' => 'set-lang', 'uses' => 'HomeController@setLang']);

//Route::group([ 'middleware' => ['maintenance_mode', 'locale']], function() {
    //Change language
  //  Route::get('set-lang/{id}', ['as' => 'set-lang', 'uses' => 'HomeController@setLang']);
//});