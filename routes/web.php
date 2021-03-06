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



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::resource('threads', 'ThreadController', [
    'except' => ['show', 'destroy']
]);
Route::get('/threads/{channel}', 'ChannelController@show');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}', 'ReplyController@store');
Route::post('/threads/{channel}/{thread}/subscribe', 'ThreadSubscriptionController@store');
Route::delete('/threads/{channel}/{thread}/subscribe', 'ThreadSubscriptionController@destroy');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');

Route::delete('/replies/{reply}', 'ReplyController@destroy');
Route::patch('/replies/{reply}', 'ReplyController@update');

Route::get('/home', 'HomeController@index');

Route::post('/likes/{model}/{id}', 'LikeController@store');
Route::delete('/likes/{model}/{id}', 'LikeController@destroy');;

Route::get('/profiles/{user}', 'ProfileController@show');
Route::get('/profiles/{user}/notifications', 'NotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'NotificationController@destroy');
