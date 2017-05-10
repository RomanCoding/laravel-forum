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
    'except' => ['show']
]);
Route::get('/threads/{channel}', 'ChannelController@show');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::post('/threads/{channel}/{thread}', 'ReplyController@store');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');

Route::delete('/replies/{reply}', 'ReplyController@destroy');
Route::patch('/replies/{reply}', 'ReplyController@update');

Route::get('/home', 'HomeController@index');

Route::post('/likes/{model}/{id}', 'LikeController@store');

Route::get('/profiles/{user}', 'ProfileController@show');
