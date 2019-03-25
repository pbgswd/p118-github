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

Route::post('/admin/topic/delete', 'TopicController@destroy');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
