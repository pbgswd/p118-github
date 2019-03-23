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

Route::get('/admin/topic/create', 'TopicController@create')->name('topic');

Route::post('/admin/topic/create', 'TopicController@store');

Route::get('/admin/topic/edit/{topic}', 'TopicController@')->name('topic_edit');

Route::post('/admin/topic/edit/{topic}', 'TopicController@store');
Route::get('/admin/topic/delete', 'TopicController@destroy')->name('topic_delete');

Route::get('/admin/topics', 'TopicController@list')->name('topics');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
