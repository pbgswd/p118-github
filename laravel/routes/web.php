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


Route::group(['middleware' => 'web'], function () {

    Auth::routes();
    //Auth::routes(['register' => false, 'reset' => false]); // turn off register route
    Route::get('/', 'HelloController@index')->name('hello');
    Route::get('contact', 'ContactController@show')->name('contact');
    Route::post('contact', 'ContactController@submit');
    Route::get('/home', 'HomeController@index')->name('home');

});


Route::group(['prefix' => 'admin', 'middleware' =>  ['web', 'auth',]], function () {

    Route::get('/', 'AdminController@index')->name('admin');

    Route::get('/topics', 'TopicController@index')->name('topics_list');
    Route::get('/topic', 'TopicController@create')->name('topic_create');
    Route::post('/topic', 'TopicController@store');
    Route::get('/topic/{topic}', 'TopicController@edit')->name('topic_edit');
    Route::post('/topic/{topic}', 'TopicController@update');
    Route::delete('/topic/delete', 'TopicController@destroy')->name('topic_destroy');

    Route::get('/users', 'UserController@index')->name('users_list');
    Route::get('/user', 'UserController@create')->name('user_create');
    Route::post('/user', 'UserController@store');
    Route::get('/user/{user}', 'UserController@edit')->name('user_edit');
    Route::post('/user/{user}', 'UserController@update');
    Route::delete('/user/delete', 'UserController@destroy')->name('user_destroy');

    Route::get('/attachment', 'AttachmentController@create')->name('attachment_create');
    Route::get('/attachments', 'AttachmentController@index')->name('attachments_list');

});
