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

    Auth::routes(['verify' => true, 'register' => false, 'reset' => true, 'login' => true]);
    // turn off register route for production, web.

    Route::get('/', 'HelloController@index')->name('hello');

    Route::get('contact', 'ContactController@show')->name('contact');
    Route::post('contact', 'ContactController@submit');

    Route::get('/hire-us', 'HireUsController@show')->name('hireus');

    Route::get('/pages', 'PageController@list')->name('pages');
    Route::get('/page/{page}', 'PageController@show')->name('page_show');

    Route::get('/topics', 'TopicController@list')->name('topics');
    Route::get('/topic/{topic}', 'TopicController@show')->name('topic_show');

    Route::get('/posts', 'PostController@list')->name('posts');
    Route::get('/post/{post}', 'PostController@show')->name('post_show');

    Route::get('/site_invitation/{inviteUser}/{password}', 'InviteUserController@show')->name('invite_user_signup');
    Route::post('/site_invitation/{inviteUser}/{password}', 'InviteUserController@process_user');
});


Route::group(['middleware' =>  ['web', 'auth',]], function () {

    //Route::get('/site', 'SiteController@index')->name('site');

    Route::get('/site', function () {
        return view('site');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('jobs', 'EmploymentController@index')->name('jobs_list');
    Route::get('job/{employment}', 'EmploymentController@show')->name('job_view');

    Route::get('/{folder}/download/{attachment}', 'AttachmentController@download')->name('attachment_download');

    Route::get('/members', 'UserController@index')->name('members');
    Route::get('/member/{user}', 'UserController@show')->name('member');
    Route::get('/member/edit/{user}', 'UserController@edit')->name('member_edit');
    Route::post('/member/edit/{user}', 'UserController@update');

    Route::get('/invited/{user}/{hash}', 'InviteUserController@process')->name('process_user');

    Route::get('agreements', 'AgreementController@list')->name('agreements_list_public');
    Route::get('/agreement/{agreement}', 'AgreementController@show')->name('agreement_show');

    Route::get('bylaws', 'ByLawController@list')->name('bylaws_list_public');
    Route::get('/bylaws/{bylaw}', 'ByLawController@show')->name('bylaw_show');

    Route::get('committees', 'CommitteeController@index')->name('committees');
    Route::get('committee/{committee}', 'CommitteeController@show')->name('committee');
    Route::post('committee/{committee}/join', 'CommitteeController@join');
    Route::post('committee/{committee}/leave', 'CommitteeController@leave');
    Route::get('committee/{committee}/show-members', 'CommitteeController@show_members')->name('committee_list_members');
    Route::get('committee/{committee}/post/{committeePost}', 'CommitteePostController@show')->name('committee_post_show');
    Route::post('committee/{committee}/post/{committeePost}', 'CommitteePostController@store');

    Route::get('committee/{committee}/post', 'CommitteeController@create_post')->name('committee_add_public_post');
    Route::post('committee/{committee}/post', 'CommitteeController@store_post');
    Route::get('committee/{committee}/edit/{committeePost}', 'CommitteeController@edit_post')->name('committee_post_edit_form');
    Route::post('committee/{committee}/edit/{committeePost}', 'CommitteeController@update_post');

    Route::post('committee/{committee}/post/{committeePost}/comment', 'CommitteePostCommentController@store')->name('committee_post_comment');

    Route::get('meetings_minutes', 'MeetingController@index')->name('list_meetings');
    Route::get('/meeting/{meeting}', 'MeetingController@show')->name('meeting');

    Route::get('/venues', 'VenueController@list')->name('venues');
    Route::get('/venue/{venue}', 'VenueController@show')->name('venue');

    Route::post('/search', 'LocalSearchController@index')->name('search');
    Route::get('/search/{search}', 'LocalSearchController@show')->name('search_show');

});

Route::group(['prefix' => 'admin', 'middleware' =>  ['web', 'auth',]], function () {

    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/blank', 'AdminController@blank')->name('blank');

    Route::post('/search', 'LocalSearchController@admin_search')->name('admin_search');
    //Route::get('/search', 'LocalSearchController@admin_index')->name('admin_search_show');
    Route::post('/attachment_search', 'LocalSearchController@admin_attachment_search')->name('list_attachments_search_result');

    Route::get('/topics', 'TopicController@index')->name('topics_list');
    Route::get('/topic', 'TopicController@create')->name('topic_create');
    Route::post('/topic', 'TopicController@store');
    Route::get('/topic/{topic}', 'TopicController@edit')->name('topic_edit');
    Route::post('/topic/{topic}', 'TopicController@update');
    Route::delete('/topic/delete', 'TopicController@destroy')->name('topic_destroy');

    Route::get('/users', 'AdminUserController@index')->name('users_list');
    Route::get('/user', 'AdminUserController@create')->name('user_create');
    Route::post('/user', 'AdminUserController@store');
    Route::get('/user/{user}', 'AdminUserController@edit')->name('user_edit');
    Route::post('/user/{user}', 'AdminUserController@update');
    Route::delete('/user/delete', 'AdminUserController@destroy')->name('user_destroy');

    Route::get('/invite_new_user', 'InviteUserController@create')->name('invite_new_user');
    Route::post('/invite_new_user', 'InviteUserController@store');
    Route::post('/invite_user', 'InviteUserController@send');
    Route::get('/invited_users', 'InviteUserController@index')->name('list_invited_users');
    Route::get('/invited_user/{inviteUser}', 'InviteUserController@show')->name('show_invited_user');
    Route::get('/invited_user/{inviteUser}', 'InviteUserController@edit')->name('invited_user_edit');
    //Route::get('/invitation-mailmsg','InviteUserController@mail')->name('mail_invited_user');
    Route::post('/invited_user/{inviteUser}', 'InviteUserController@update');
    Route::delete('/invited_user/delete', 'InviteUserController@destroy')->name('invited_user_destroy');

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
    Route::get('/attachment/{attachment}', 'AttachmentController@edit')->name('admin_attachment_edit');
    Route::post('/attachment/{attachment}', 'AttachmentController@update');
    Route::delete('/attachment/delete', 'AttachmentController@destroy')->name('attachment_destroy');

    Route::get('/{folder}/attachment/{attachment}', 'AttachmentController@download')->name('attachment_download');

    Route::get('/roles', 'RoleController@index')->name('roles_list');

    Route::get('/venues', 'VenueController@index')->name('venues_list');
    Route::get('/venue', 'VenueController@create')->name('venue_create');
    Route::post('/venue', 'VenueController@store');
    Route::get('/venue/{venue}', 'VenueController@edit')->name('venue_edit');
    Route::post('/venue/{venue}', 'VenueController@update');
    Route::delete('/venue/delete', 'VenueController@destroy')->name('venue_destroy');

    Route::get('committees', 'AdminCommitteeController@index')->name('committees_list');
    Route::get('committee/', 'AdminCommitteeController@create')->name('committee_create');
    Route::post('committee/', 'AdminCommitteeController@store');
    Route::get('committee/show/{committee}', 'AdminCommitteeController@show')->name('committee_show');
    Route::get('committee/{committee}', 'AdminCommitteeController@edit')->name('committee_edit');
    Route::post('committee/{committee}', 'AdminCommitteeController@update');
    Route::delete('committee/delete', 'AdminCommitteeController@destroy')->name('committee_destroy');

    Route::get('committee/{committee}/list-bulk-add', 'AdminCommitteeMemberController@index')->name('list-bulk-add');
    Route::post('committee/{committee}/list-bulk-add', 'AdminCommitteeMemberController@store');

    Route::get('committee/{committee}/posts/list', 'CommitteePostController@index')->name('committee_posts_list');
    Route::get('committee/{committee}/post', 'CommitteePostController@create')->name('committee_post');
    Route::post('committee/{committee}/post', 'CommitteePostController@store');
    Route::get('committee/{committee}/post/{committeePost}/edit', 'CommitteePostController@edit')->name('committee_post_edit');
    Route::post('committee/{committee}/post/{committeePost}/edit', 'CommitteePostController@update');
    Route::delete('committee/{committee}/post/delete', 'CommitteePostController@destroy')->name('committee_post_destroy');

    Route::get('agreements', 'AgreementController@index')->name('agreements_list');
    Route::get('agreement/', 'AgreementController@create')->name('agreement_create');
    Route::post('agreement/', 'AgreementController@store');
    Route::delete('/agreement/delete', 'AgreementController@destroy')->name('agreement_destroy');
    Route::get('/agreement/{agreement}', 'AgreementController@edit')->name('agreement_edit');
    Route::post('/agreement/{agreement}', 'AgreementController@update');

    Route::get('/organizations', 'OrganizationController@index')->name('organizations_list');
    Route::get('/organization/', 'OrganizationController@create')->name('organization_create');
    Route::post('/organization/', 'OrganizationController@store');
    Route::post('/organization/{organization}', 'OrganizationController@update');
    Route::delete('/organization/delete', 'OrganizationController@destroy')->name('organization_destroy');
    Route::get('/organization/{organization}', 'OrganizationController@edit')->name('organization_edit');

    Route::get('/meetings', 'AdminMeetingController@index')->name('meetings_list');
    Route::get('/meeting/', 'AdminMeetingController@create')->name('meeting_create');
    Route::post('/meeting/', 'AdminMeetingController@store');
    Route::post('/meeting/{meeting}', 'AdminMeetingController@update');
    Route::delete('/meeting/delete', 'AdminMeetingController@destroy')->name('meeting_destroy');
    Route::get('/meeting/{meeting}', 'AdminMeetingController@edit')->name('meeting_edit');

    Route::get('employment-list/', 'AdminEmploymentController@index')->name('admin_employment_list');
    Route::get('employment/', 'AdminEmploymentController@create')->name('admin_employment_create');
    Route::post('employment/', 'AdminEmploymentController@store');
    Route::post('employment/{employment}', 'AdminEmploymentController@update');
    Route::delete('/employment/delete', 'AdminEmploymentController@destroy')->name('admin_employment_destroy');
    Route::get('/employment/{employment}', 'AdminEmploymentController@edit')->name('admin_employment_edit');

    Route::get('bylaws-list/', 'ByLawController@index')->name('admin_bylaws_list');
    Route::get('bylaw/', 'ByLawController@create')->name('admin_bylaw_create');
    Route::post('bylaw/', 'ByLawController@store');
    Route::post('bylaw/{bylaw_id}', 'ByLawController@update');
    Route::delete('/bylaw/delete', 'ByLawController@destroy')->name('admin_bylaw_destroy');

    Route::get('/bylaw/{bylaw_id}', 'ByLawController@edit')->name('admin_bylaw_edit');

});
