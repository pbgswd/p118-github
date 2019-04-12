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

Route::get('/hello', 'HelloController@index')->name('hello');

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/admin/topics', 'TopicController@index')->name('topics_list');
Route::get('/admin/topic', 'TopicController@create')->name('topic_create');
Route::post('/admin/topic', 'TopicController@store');
Route::get('/admin/topic/{topic}', 'TopicController@edit')->name('topic_edit');
Route::post('/admin/topic/{topic}', 'TopicController@update');
Route::delete('/admin/topic/delete', 'TopicController@destroy')->name('topic_destroy');

Route::get('/admin/users', 'UserController@index')->name('users_list');
Route::get('/admin/user', 'UserController@create')->name('user_create');
Route::post('/admin/user', 'UserController@store');
Route::get('/admin/user/{user}', 'UserController@edit')->name('user_edit');
Route::post('/admin/user/{user}', 'UserController@update');
Route::delete('/admin/user/delete', 'UserController@destroy')->name('user_destroy');

Route::get('contact', 'ContactController@show')->name('contact');
Route::post('contact', 'ContactController@submit');

Route::get('/admin/attachment', 'AttachmentController@create')->name('attachment_create');
Route::get('/admin/attachments', 'AttachmentController@index')->name('attachments_list');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
