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

    Route::get('/pages', 'PageController@list')->name('pages');
    Route::get('/page/{page}', 'PageController@show')->name('page_show');

    Route::get('/topics', 'TopicController@list')->name('topics');
    Route::get('/topic/{topic}', 'TopicController@show')->name('topic_show');

    Route::get('/posts', 'PostController@list')->name('posts');
    Route::get('/post/{post}', 'PostController@show')->name('post_show');

    Route::get('/venues', 'VenueController@list')->name('venues');
    Route::get('/venue/{venue}', 'VenueController@show')->name('venue');

    Route::post('/search', 'SearchController@index')->name('search');

});

Route::group(['middleware' =>  ['web', 'auth',]], function () {

    //Route::get('/site', 'SiteController@index')->name('site');

    Route::get('/site', function () {
        return view('site');
    });
});


Route::group(['prefix' => 'admin', 'middleware' =>  ['web', 'auth',]], function () {

    Route::get('/member', function () {
        return view('admin.member');
    });

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

    Route::get('/pages', 'PageController@index')->name('pages_list');
    Route::get('/page', 'PageController@create')->name('page_create');
    Route::post('/page', 'PageController@store');
    Route::get('/page/{page}', 'PageController@edit')->name('page_edit');
    Route::post('/page/{page}', 'PageController@update');
    Route::delete('/page/delete', 'PageController@destroy')->name('page_destroy');

    Route::get('/posts', 'PostController@index')->name('posts_list');
    Route::get('/post', 'PostController@create')->name('post_create');
    Route::post('/post', 'PostController@store');
    Route::get('/post/{post}', 'PostController@edit')->name('post_edit');
    Route::post('/post/{post}', 'PostController@update');
    Route::delete('/post/delete', 'PostController@destroy')->name('post_destroy');

    Route::get('/attachment', 'AttachmentController@create')->name('attachment_create');
    Route::get('/attachments', 'AttachmentController@index')->name('attachments_list');
    Route::post('/attachment', 'AttachmentController@store');
    Route::get('/attachment/{attachment}', 'AttachmentController@edit')->name('attachment_edit');
    Route::post('/attachment/{attachment}', 'AttachmentController@update');
    Route::delete('/attachment/delete', 'AttachmentController@destroy')->name('attachment_destroy');

    Route::get('/roles', 'RoleController@index')->name('roles_list');

    Route::get('/venues', 'VenueController@index')->name('venues_list');
    Route::get('/venue', 'VenueController@create')->name('venue_create');
    Route::post('/venue', 'VenueController@store');
    Route::get('/venue/{venue}', 'VenueController@edit')->name('venue_edit');
    Route::post('/venue/{venue}', 'VenueController@update');
    Route::delete('/venue/delete', 'VenueController@destroy')->name('venue_destroy');

});
