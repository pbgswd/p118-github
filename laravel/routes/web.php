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

    Route::get('/{folder}/download/{attachment}', 'AttachmentController@download')->name('attachment_download');
});


Route::group(['middleware' =>  ['web', 'auth',]], function () {

    //Route::get('/site', 'SiteController@index')->name('site');

    Route::get('/site', function () {
        return view('site');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('jobs', 'EmploymentController@index')->name('jobs_list');
    Route::get('job/{employment}', 'EmploymentController@show')->name('job_view');

    Route::get('/members', 'UserController@index')->name('members');
    Route::get('/member/{user}', 'UserController@show')->name('member');
    Route::get('/member/{user}/edit', 'UserController@edit')->name('member_edit');
    Route::post('/member/{user}/edit', 'UserController@update');

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

    Route::get('committee/{committee}/post/create', 'CommitteePostController@create')->name('committee_add_public_post');
    Route::post('committee/{committee}/post/create', 'CommitteePostController@store');
    Route::get('committee/{committee}/post/{committeePost}', 'CommitteePostController@show')->name('public_committee_post_show');

    //Route::post('committee/{committee}/post/{committeePost}/create', 'CommitteePostController@store');

    Route::get('committee/{committee}/post/{committeePost}/edit', 'CommitteePostController@edit')->name('committee_post_edit_form');
    Route::post('committee/{committee}/post/{any_committee_post}/edit', 'CommitteePostController@update');

    Route::delete('committee/{committee}/post/{committeePost}/destroy', 'CommitteePostController@destroy')->name('public_committee_post_destroy');

    Route::post('committee/{committee}/post/{committeePost}/comment/create', 'CommitteePostCommentController@store')->name('public_committee_post_comment');

    Route::get('meetings_minutes', 'MeetingController@index')->name('list_meetings');
    Route::get('/meeting/{meeting}', 'MeetingController@show')->name('meeting');

    Route::get('/venues', 'VenueController@list')->name('venues');
    Route::get('/venue/{venue}', 'VenueController@show')->name('venue');

    Route::get('/organizations', 'OrganizationController@list')->name('organizations');
    Route::get('/organization/{organization}', 'OrganizationController@show')->name('organization');

    Route::post('/search', 'LocalSearchController@index')->name('search');
    Route::get('/search/{search}', 'LocalSearchController@show')->name('search_show');

   // Route::get('/{folder}/attachment/{attachment}', 'AttachmentController@download')->name('attachment_download');

});

Route::group(['prefix' => 'admin', 'middleware' =>  ['web', 'auth',]], function () {

    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/blank', 'AdminController@blank')->name('blank');

    Route::post('/search', 'LocalSearchController@admin_search')->name('admin_search');
    //Route::get('/search', 'LocalSearchController@admin_index')->name('admin_search_show');
    Route::post('/attachment_search', 'LocalSearchController@admin_attachment_search')->name('list_attachments_search_result');

    Route::get('/topics', 'AdminTopicController@index')->name('topics_list');
    Route::get('/topic/create', 'AdminTopicController@create')->name('topic_create');
    Route::post('/topic/create', 'AdminTopicController@store');
    Route::get('/topic/{any_topic}/edit', 'AdminTopicController@edit')->name('topic_edit');
    Route::post('/topic/{any_topic}/edit', 'AdminTopicController@update');
    Route::delete('/topic/delete', 'AdminTopicController@destroy')->name('topic_destroy');

    Route::get('/users', 'AdminUserController@index')->name('users_list');
    Route::get('/user/create', 'AdminUserController@create')->name('user_create');
    Route::post('/user/create', 'AdminUserController@store');
    Route::get('/user/{user}/edit', 'AdminUserController@edit')->name('user_edit');
    Route::post('/user/{user}/edit', 'AdminUserController@update');
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

    Route::get('/pages', 'AdminPageController@index')->name('pages_list');
    Route::get('/page/create', 'AdminPageController@create')->name('page_create');
    Route::post('/page/create', 'AdminPageController@store');
    Route::get('/page/{any_page}/edit', 'AdminPageController@edit')->name('page_edit');
    Route::post('/page/{any_page}/edit', 'AdminPageController@update')->name('admin_update_page');
    Route::delete('/page/delete', 'AdminPageController@destroy')->name('page_destroy');

    Route::get('/posts', 'AdminPostController@index')->name('posts_list');
    Route::get('/post/create', 'AdminPostController@create')->name('post_create');
    Route::post('/post/create', 'AdminPostController@store');
    Route::get('/post/{any_post}/edit', 'AdminPostController@edit')->name('post_edit');
    Route::post('/post/{any_post}/edit', 'AdminPostController@update');
    Route::delete('/post/delete', 'AdminPostController@destroy')->name('post_destroy');

    Route::get('/attachments', 'AttachmentController@index')->name('attachments_list');
    Route::get('/attachment/create', 'AttachmentController@create')->name('attachment_create');
    Route::post('/attachment/create', 'AttachmentController@store');
    Route::get('/attachment/{attachment}/edit', 'AttachmentController@edit')->name('admin_attachment_edit');
    Route::post('/attachment/{attachment}/edit', 'AttachmentController@update');
    Route::delete('/attachment/delete', 'AttachmentController@destroy')->name('attachment_destroy');

    Route::get('/roles', 'RoleController@index')->name('roles_list');

    Route::get('/venues', 'AdminVenueController@index')->name('venues_list');
    Route::get('/venue/create', 'AdminVenueController@create')->name('venue_create');
    Route::post('/venue/create', 'AdminVenueController@store');
    Route::get('/venue/{any_venue}/edit', 'AdminVenueController@edit')->name('venue_edit');
    Route::post('/venue/{any_venue}/edit', 'AdminVenueController@update');
    Route::delete('/venue/delete', 'AdminVenueController@destroy')->name('venue_destroy');

    Route::get('committees', 'AdminCommitteeController@index')->name('committees_list');
    Route::get('committee/create', 'AdminCommitteeController@create')->name('committee_create');
    Route::post('committee/create', 'AdminCommitteeController@store');
    Route::get('committee/{any_committee}/show', 'AdminCommitteeController@show')->name('admin_committee_show');
    Route::get('committee/{any_committee}/edit', 'AdminCommitteeController@edit')->name('committee_edit');
    Route::post('committee/{any_committee}/edit', 'AdminCommitteeController@update');
    Route::delete('committee/delete', 'AdminCommitteeController@destroy')->name('committee_destroy');

    Route::get('committee/{committee}/list-bulk-add', 'AdminCommitteeMemberController@index')->name('list-bulk-add');
    Route::post('committee/{committee}/list-bulk-add', 'AdminCommitteeMemberController@store');

    Route::get('committee/{committee}/posts', 'AdminCommitteePostController@index')->name('committee_posts_list');
    Route::get('committee/{committee}/post/create', 'AdminCommitteePostController@create')->name('admin_committee_post');
    Route::post('committee/{committee}/post/create', 'AdminCommitteePostController@store');
    Route::get('committee/{committee}/post/{any_committee_post}/edit', 'AdminCommitteePostController@edit')->name('admin_committee_post_edit');
    Route::post('committee/{committee}/post/{any_committee_post}/edit', 'AdminCommitteePostController@update');
    Route::delete('committee/{committee}/post/delete', 'AdminCommitteePostController@destroy')->name('committee_post_destroy');

    route::get('committee_post/{any_committee_post}/committee_post_comment/create', 'AdminCommitteePostCommentController@create')->name('admin_committee_post_comment');
    route::post('committee_post/{any_committee_post}/committee_post_comment/create', 'AdminCommitteePostCommentController@store');
    route::get('committee_post/{any_committee_post}/committee_post_comment/edit/{any_committee_post_comment}', 'AdminCommitteePostCommentController@edit')->name('admin_committee_post_comment_edit');
    route::post('committee_post/{any_committee_post}/committee_post_comment/edit/{any_committee_post_comment}', 'AdminCommitteePostCommentController@update');
    route::delete('committee_post_comment/delete/', 'AdminCommitteePostCommentController@destroy')->name('committee_post_comment_destroy');

    Route::get('agreements', 'AdminAgreementController@index')->name('agreements_list');
    Route::get('agreement/create', 'AdminAgreementController@create')->name('agreement_create');
    Route::post('agreement/create', 'AdminAgreementController@store');
    Route::delete('/agreement/delete', 'AdminAgreementController@destroy')->name('agreement_destroy');
    Route::get('/agreement/{any_agreement}/edit', 'AdminAgreementController@edit')->name('agreement_edit');
    Route::post('/agreement/{any_agreement}/edit', 'AdminAgreementController@update');

    Route::get('/organizations', 'AdminOrganizationController@index')->name('organizations_list');
    Route::get('/organization/create', 'AdminOrganizationController@create')->name('organization_create');
    Route::post('/organization/create', 'AdminOrganizationController@store');
    Route::get('/organization/{any_organization}/edit', 'AdminOrganizationController@edit')->name('organization_edit');
    Route::post('/organization/{any_organization}/edit', 'AdminOrganizationController@update');
    Route::delete('/organization/delete', 'AdminOrganizationController@destroy')->name('organization_destroy');

    Route::get('/meetings', 'AdminMeetingController@index')->name('meetings_list');
    Route::get('/meeting/create', 'AdminMeetingController@create')->name('meeting_create');
    Route::post('/meeting/create', 'AdminMeetingController@store');
    Route::get('/meeting/{any_meeting}/edit', 'AdminMeetingController@edit')->name('meeting_edit');
    Route::post('/meeting/{any_meeting}/edit', 'AdminMeetingController@update');
    Route::delete('/meeting/delete', 'AdminMeetingController@destroy')->name('meeting_destroy');

    Route::get('employment-list/', 'AdminEmploymentController@index')->name('admin_employment_list');
    Route::get('employment/create', 'AdminEmploymentController@create')->name('admin_employment_create');
    Route::post('employment/create', 'AdminEmploymentController@store');
    Route::get('/employment/{any_employment}/edit', 'AdminEmploymentController@edit')->name('admin_employment_edit');
    Route::post('employment/{any_employment}/edit', 'AdminEmploymentController@update');
    Route::delete('/employment/delete', 'AdminEmploymentController@destroy')->name('admin_employment_destroy');

    Route::get('bylaws/', 'AdminByLawController@index')->name('admin_bylaws_list');
    Route::get('bylaw/create', 'AdminByLawController@create')->name('admin_bylaw_create');
    Route::post('bylaw/create', 'AdminByLawController@store');
    Route::get('/bylaw/{any_bylaw}/edit', 'AdminByLawController@edit')->name('admin_bylaw_edit');
    Route::post('bylaw/{any_bylaw}/edit', 'AdminByLawController@update');
    Route::delete('/bylaw/delete', 'AdminByLawController@destroy')->name('admin_bylaw_destroy');
});
