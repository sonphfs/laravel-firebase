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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/check', function(){
    return "deploying with Git";
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/laravel-firebase','FirebaseController@index');
    Route::get('/firebase', 'FirebaseController@firebaseClient');
    Route::post('/send-message', 'FirebaseController@sendMessage');
    Route::get('/create-user', 'FirebaseController@createUser');
    Route::get('/create-user-by-id/{id}', 'FirebaseController@createUserById');
    Route::get('/update-user/{id}', 'FirebaseController@updateUser');
    Route::get('/user-info/{id}', 'FirebaseController@getUserInfo');
    Route::get('/auth/{id}', 'FirebaseController@auth');
    Route::get('/list-users', 'FirebaseController@getListUsers');
    Route::get('/logout', 'FirebaseController@logout');
    Route::get('/load-message-from-firebase', 'FirebaseController@loadMessageFromFirebase');
});
