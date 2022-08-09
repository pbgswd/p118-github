<?php

use App\Http\Controllers as CNS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; //Controller Name Space

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

/**
 * PUBLIC ACCESS
 */
Route::middleware('web')->group(function () {
    Auth::routes(['verify' => true, 'register' => false, 'reset' => true, 'login' => true]);

    //Route::get('sendemail', [CNS\MailController::class, 'index']);

    Route::get('/', [CNS\HelloController::class, 'index'])->name('hello');

    Route::get('contact', [CNS\ContactController::class, 'show'])->name('contact');
    Route::post('contact', [CNS\ContactController::class, 'submit']);

    Route::get('carousel', [CNS\CarouselController::class, 'show'])->name('carousel');

    Route::get('memoriams', [CNS\MemoriamController::class, 'index'])->name('memoriam_list');
    Route::get('memoriam/{memoriam}', [CNS\MemoriamController::class, 'show'])->name('memoriam');

    Route::get('executive', [CNS\ExecutiveController::class, 'index'])->name('executive');

    //Route::get('/hire-us', [CNS\HireUsController::class, 'show'])->name('hire-us'); // to be updated

    Route::get('/pages', [CNS\PageController::class, 'list'])->name('pages');
    Route::get('/page/{page}', [CNS\PageController::class, 'show'])->name('page_show');

    Route::get('/topics', [CNS\TopicController::class, 'list'])->name('topics');
    Route::get('/topic/{topic}', [CNS\TopicController::class, 'show'])->name('topic_show');

    Route::controller(CNS\PostController::class)->group(function() {
       Route::get('/posts', 'list')->name('posts');
       Route::get('/post/{post}', 'show')->name('post_show');
    });

    Route::get('/site_invitation/{inviteUser}/{password}', [CNS\InviteUserController::class, 'show'])
        ->name('invite_user_signup');
    Route::post('/site_invitation/{inviteUser}/{password}', [CNS\InviteUserController::class, 'process_user']);

    Route::get('/venues', [CNS\VenueController::class, 'list'])->name('venues');
    Route::get('/venue/{venue}', [CNS\VenueController::class, 'show'])->name('venue');

    Route::get('/organizations', [CNS\OrganizationController::class, 'list'])->name('organizations');
    Route::get('/organization/{organization}', [CNS\OrganizationController::class, 'show'])->name('organization');

    Route::get('agreements', [CNS\AgreementController::class, 'list'])->name('agreements_list_public');
    Route::get('/agreement/{agreement}', [CNS\AgreementController::class, 'show'])->name('agreement_show');

    Route::get('bylaws', [CNS\ByLawController::class, 'list'])->name('bylaws_list_public');
    Route::get('/bylaw/{bylaw}', [CNS\ByLawController::class, 'show'])->name('bylaw_show');

    Route::get('/{folder}/download/{attachment}', [CNS\AttachmentController::class, 'download'])
        ->name('attachment_download')->middleware('throttle:download');
});

/**
 * MEMBERS LOGGED IN
 */
Route::middleware('web', 'auth')->group(function () {
    Route::get('/site', [CNS\SiteController::class, 'index'])->name('landing_page');

    Route::get('/home', [CNS\HomeController::class, 'index'])->name('home'); // redirects to home page

    Route::post('jobs', [CNS\EmploymentController::class, 'jobs_year'])->name('jobs_year');
    Route::get('jobs/{deadline}', [CNS\EmploymentController::class, 'index_by_year'])->name('list_jobs_year');

    Route::get('jobs', [CNS\EmploymentController::class, 'index'])->name('jobs_list');
    Route::get('job/{employment}', [CNS\EmploymentController::class, 'show'])->name('job_view');

    Route::get('features', [CNS\FeatureController::class, 'index'])->name('features');
    Route::get('feature/{feature}', [CNS\FeatureController::class, 'show'])->name('feature');


    Route::controller(CNS\UserController::class)->group(function() {
        Route::get('/members', 'index')->name('members');
        Route::get('/member/{user}', 'show')->name('member');
        Route::get('/member/{user}/edit', 'edit')->name('member_edit');
        Route::post('/member/{user}/edit', 'update');
        Route::get('/member/{user}/address/edit', 'edit_address')->name('member_address_edit');
        Route::post('/member/{user}/address/edit', 'update_address');
        Route::get('/member/{user}/emergency_contact/edit', 'edit_emergency_contact')->name('edit_emergency_contact');
        Route::post('/member/{user}/emergency_contact/edit', 'update_emergency_contact');
        Route::get('/member/{user}/password', 'edit_password')->name('member_password_edit');
        Route::post('/member/{user}/password', 'update_password');
    });

    Route::get('policies', [CNS\PolicyController::class, 'index'])->name('policies_list_public');
    Route::get('/policies/{policy}', [CNS\PolicyController::class, 'show'])->name('policy_show_public');

    Route::get('committees', [CNS\CommitteeController::class, 'index'])->name('committees');
    Route::get('committee/{committee}', [CNS\CommitteeController::class, 'show'])->name('committee');

    Route::get('committee/{committee}/post/create', [CNS\CommitteePostController::class, 'create'])
        ->name('committee_add_public_post');
    Route::post('committee/{committee}/post/create', [CNS\CommitteePostController::class, 'store']);

    Route::get('committee/{committee}/post/{committeePost}', [CNS\CommitteePostController::class, 'show'])
        ->name('public_committee_post_show');

    //Route::post('committee/{committee}/post/{committeePost}/create[, 'CNS\CommitteePostController::class, 'store']);

    Route::get('committee/{committee}/post/{committeePost}/edit', [CNS\CommitteePostController::class, 'edit'])
        ->name('committee_post_edit_form');
    Route::post('committee/{committee}/post/{any_committee_post}/edit', [CNS\CommitteePostController::class, 'update']);

    Route::delete('committee/{committee}/post/{committeePost}/destroy', [CNS\CommitteePostController::class, 'destroy'])
        ->name('public_committee_post_destroy');

    //Route::post('committee/{committee}/post/{committeePost}/comment/create',
    // [CNS\CommitteePostCommentController::class, 'store'])
//    ->name('public_committee_post_comment');

    Route::controller(CNS\MeetingController::class)->group(function() {
        Route::post('minutes', 'post_year')->name('post_year');
        Route::get('minutes/year/{year}', 'index_by_year')->name('list_meetings_year');
        Route::get('minutes', 'index')->name('list_meetings');
        Route::get('minutes/{meeting}', 'show')->name('meeting');
    });

    Route::post('/search', [CNS\LocalSearchController::class, 'index'])->name('search');
});

/**
 * ADMIN SECTION
 */
Route::prefix('admin')->middleware('role:super-admin|office|committee|writer')->group(function () {
    Route::get('/', [CNS\AdminController::class, 'index'])->name('admin');
    Route::get('/blank', [CNS\AdminController::class, 'blank'])->name('blank');
    Route::get('/developer', [CNS\AdminController::class, 'developer'])->name('developer');

    Route::resource('carousel', CNS\AdminCarouselController::class);

    Route::controller(CNS\AdminMemoriamController::class)->group(function(){
        Route::get('memoriams', 'index')->name('admin_memoriam_list');
        Route::get('memoriam/create', 'create')->name('admin_memoriam_create');
        Route::post('memoriam/create', 'store');
        Route::get('memoriam/{any_memoriam}/edit', 'edit')->name('admin_memoriam_edit');
        Route::post('memoriam/{any_memoriam}/edit', 'update');
        Route::delete('memoriam/delete', 'destroy')->name('admin_memoriam_destroy');
    });

    Route::get('proofreading-sync', [CNS\AdminProofReaderController::class, 'sync'])->name('admin_proofreader_sync');
    Route::get('proofreading', [CNS\AdminProofReaderController::class, 'index'])->name('admin_proofreader');
    Route::post('proofreading', [CNS\AdminProofReaderController::class, 'index_by_entity'])->name('index_by_entity');
    Route::post('proofreading/{proofReader}/update', [CNS\AdminProofReaderController::class, 'update']);

    Route::post('/search', [CNS\LocalSearchController::class, 'admin_search'])->name('admin_search');
    //Route::get('/search', [CNS\LocalSearchController::class, 'admin_index'])->name('admin_search_show');
    Route::post('/attachment_search', [CNS\LocalSearchController::class, 'admin_attachment_search'])
        ->name('list_attachments_search_result');

    Route::get('features', [CNS\AdminFeatureController::class, 'index'])->name('admin_features_list');
    Route::get('feature/create', [CNS\AdminFeatureController::class, 'create'])->name('admin_feature_create');
    Route::post('feature/create', [CNS\AdminFeatureController::class, 'store']);
    Route::get('feature/{any_feature}/edit', [CNS\AdminFeatureController::class, 'edit'])->name('admin_feature_edit');
    Route::post('feature/{any_feature}/edit', [CNS\AdminFeatureController::class, 'update']);
    Route::delete('feature/delete', [CNS\AdminFeatureController::class, 'destroy'])->name('admin_feature_destroy');

    Route::get('/policies', [CNS\AdminPolicyController::class, 'index'])->name('policies_list');
    Route::get('/policy/create', [CNS\AdminPolicyController::class, 'create'])->name('admin_policy_create');
    Route::post('/policy/create', [CNS\AdminPolicyController::class, 'store']);
    Route::get('/policy/{any_policy}/edit', [CNS\AdminPolicyController::class, 'edit'])->name('admin_policy_edit');
    Route::post('/policy/{any_policy}/edit', [CNS\AdminPolicyController::class, 'update']);
    Route::delete('/policy/delete', [CNS\AdminPolicyController::class, 'destroy'])->name('admin_policy_destroy');

    Route::get('/topics', [CNS\AdminTopicController::class, 'index'])->name('topics_list');
    Route::get('/topic/create', [CNS\AdminTopicController::class, 'create'])->name('topic_create');
    Route::post('/topic/create', [CNS\AdminTopicController::class, 'store']);
    Route::get('/topic/{any_topic}/edit', [CNS\AdminTopicController::class, 'edit'])->name('topic_edit');
    Route::post('/topic/{any_topic}/edit', [CNS\AdminTopicController::class, 'update']);
    Route::delete('/topic/delete', [CNS\AdminTopicController::class, 'destroy'])->name('topic_destroy');

    Route::controller(CNS\AdminUserController::class)->group(function() {
        Route::get('/users', 'index')->name('users_list');
        Route::get('/user/create', 'create')->name('user_create');
        Route::post('/user/create', 'store');
        Route::get('/user/{user}/address/edit', 'admin_edit_address')->name('admin_edit_address');
        Route::post('/user/{user}/address/edit', 'admin_update_address');
        Route::get('/user/{user}/emergency_contact/edit', 'admin_edit_emergency_contact')
            ->name('admin_edit_emergency_contact');
        Route::post('/user/{user}/emergency_contact/edit', 'admin_update_emergency_contact');
        Route::get('/user/{user}/edit', 'edit')->name('user_edit');
        Route::post('/user/{user}/edit', 'update')->name('user_edit_update');
        Route::delete('/user/delete', 'destroy')->name('user_destroy');
    });

    Route::get('/executives', [CNS\AdminExecutiveMembershipController::class, 'index'])
        ->name('admin_executives_list');

    Route::get('/user/{user}/executiveMembership/create', [CNS\AdminExecutiveMembershipController::class, 'create'])
        ->name('admin_executive_create');
    Route::post('/user/{user}/executiveMembership/create', [CNS\AdminExecutiveMembershipController::class, 'store']);
    Route::get('/executiveMembership/{executiveMembership}/edit', [CNS\AdminExecutiveMembershipController::class, 'edit'])
        ->name('admin_executive_edit');
    Route::post('/executiveMembership/{executiveMembership}/edit', [CNS\AdminExecutiveMembershipController::class, 'update']);

    Route::get('executive_members', [CNS\AdminExecutiveController::class, 'index'])->name('admin_executives');
    Route::delete('executives/delete', [CNS\AdminExecutiveMembershipController::class, 'destroy'])
        ->name('admin_executive_destroy');

    Route::get('/invite-new-user', [CNS\InviteUserController::class, 'create'])->name('invite-new-user');
    Route::post('/invite-new-user', [CNS\InviteUserController::class, 'store']);
    Route::get('/invited_users', [CNS\InviteUserController::class, 'index'])->name('admin_list_invited_users');
    Route::get('/invited_user/{inviteUser}', [CNS\InviteUserController::class, 'show'])->name('show_invited_user');

    //Route::get('/invitation-mailmsg',[CNS\InviteUserController::class, 'mail'])->name('mail_invited_user');
    Route::delete('/invited_user/delete', [CNS\InviteUserController::class, 'destroy'])->name('invited_user_destroy');
    Route::get('/invite_import-list', [CNS\InviteUserController::class, 'list_import'])->name('list_import');
    Route::get('process_import_invitation', [CNS\InviteUserController::class, 'process_import_invitation'])
        ->name('process_import_invitation');

    Route::get('/invite-resend-list', [CNS\ReInviteUserController::class, 'index'])->name('invite-resend-list');

    Route::get('/pages', [CNS\AdminPageController::class, 'index'])->name('pages_list');
    Route::get('/page/create', [CNS\AdminPageController::class, 'create'])->name('page_create');
    Route::post('/page/create', [CNS\AdminPageController::class, 'store']);
    Route::get('/page/{any_page}/edit', [CNS\AdminPageController::class, 'edit'])->name('page_edit');
    Route::post('/page/{any_page}/edit', [CNS\AdminPageController::class, 'update'])->name('admin_update_page');
    Route::delete('/page/delete', [CNS\AdminPageController::class, 'destroy'])->name('page_destroy');

    Route::get('/posts', [CNS\AdminPostController::class, 'index'])->name('posts_list');
    Route::get('/post/create', [CNS\AdminPostController::class, 'create'])->name('post_create');
    Route::post('/post/create', [CNS\AdminPostController::class, 'store']);
    Route::get('/post/{any_post}/edit', [CNS\AdminPostController::class, 'edit'])->name('post_edit');
    Route::post('/post/{any_post}/edit', [CNS\AdminPostController::class, 'update']);
    Route::delete('/post/delete', [CNS\AdminPostController::class, 'destroy'])->name('post_destroy');

    Route::get('/attachments', [CNS\AttachmentController::class, 'index'])->name('attachments_list');
    Route::get('/attachment/create', [CNS\AttachmentController::class, 'create'])->name('attachment_create');
    Route::post('/attachment/create', [CNS\AttachmentController::class, 'store']);
    Route::get('/attachment/{attachment}/edit', [CNS\AttachmentController::class, 'edit'])
        ->name('admin_attachment_edit');
    Route::post('/attachment/{attachment}/edit', [CNS\AttachmentController::class, 'update']);
    Route::delete('/attachment/delete', [CNS\AttachmentController::class, 'destroy'])->name('attachment_destroy');

    Route::get('/roles', [CNS\RoleController::class, 'index'])->name('roles_list');

    Route::get('/venues', [CNS\AdminVenueController::class, 'index'])->name('venues_list');
    Route::get('/venue/create', [CNS\AdminVenueController::class, 'create'])->name('venue_create');
    Route::post('/venue/create', [CNS\AdminVenueController::class, 'store']);
    Route::get('/venue/{any_venue}/edit', [CNS\AdminVenueController::class, 'edit'])->name('venue_edit');
    Route::post('/venue/{any_venue}/edit', [CNS\AdminVenueController::class, 'update']);
    Route::delete('/venue/delete', [CNS\AdminVenueController::class, 'destroy'])->name('venue_destroy');

    Route::controller(CNS\AdminCommitteeMemberController::class)->group(function() {
        Route::post('committee/{committee}/admin-list-committee-members', 'search');
        Route::get('committee/{committee}/admin-list-committee-members', 'index')->name('admin-list-committee-members');
        Route::get('committee/{committee}/admin-create-committee-members/user/{user}','create')
            ->name('admin_create_committee_members');
        Route::post('committee/{committee}/admin-create-committee-members/user/{user}','store');
        Route::get('committee/{committee}/admin-edit-committee-members/user/{user}','edit')
            ->name('admin_edit_committee_members');
        Route::post('committee/{committee}/admin-edit-committee-members/user/{user}','update');
        Route::delete('committee/{committee}/admin-manage-committee-members/user/{user}/delete','destroy')
            ->name('admin_delete-committee_member');
    });

    Route::controller(CNS\AdminCommitteeController::class)->group(function() {
        Route::get('committees', 'index')->name('committees_list');
        Route::get('committee/create', 'create')->name('committee_create');
        Route::post('committee/create', 'store');
        Route::get('committee/{any_committee}/show', 'show')
            ->name('admin_committee_show');
        Route::get('committee/{any_committee}/edit', 'edit')
            ->name('committee_edit');
        Route::post('committee/{any_committee}/edit', 'update');
        Route::delete('committee/delete', 'destroy')->name('committee_destroy');
    });

    Route::controller(CNS\AdminCommitteePostController::class)->group(function() {
        Route::get('committee/{committee}/posts','index')->name('committee_posts_list');
        Route::get('committee/{committee}/post/create','create')->name('admin_committee_post');
        Route::post('committee/{committee}/post/create','store');
        Route::get('committee/{committee}/post/{any_committee_post}/edit','edit')->name('admin_committee_post_edit');
        Route::post('committee/{committee}/post/{any_committee_post}/edit','update');
        Route::delete('committee/{committee}/post/delete','destroy')
            ->name('committee_post_destroy');
    });

    /****
    route::get('committee_post/{any_committee_post}/committee_post_comment/create',
        [CNS\AdminCommitteePostCommentController::class, 'create'])->name('admin_committee_post_comment');
    route::post('committee_post/{any_committee_post}/committee_post_comment/create',
        [CNS\AdminCommitteePostCommentController::class, 'store']);
    route::get('committee_post/{any_committee_post}/committee_post_comment/edit/{any_committee_post_comment}',
        [CNS\AdminCommitteePostCommentController::class, 'edit'])->name('admin_committee_post_comment_edit');
    route::post('committee_post/{any_committee_post}/committee_post_comment/edit/{any_committee_post_comment}',
        [CNS\AdminCommitteePostCommentController::class, 'update']);
    route::delete('committee_post_comment/delete/', [CNS\AdminCommitteePostCommentController::class, 'destroy'])
        ->name('committee_post_comment_destroy');
    ***/

    Route::controller(CNS\AdminAgreementController::class)->group(function() {
        Route::get('agreements', 'index')->name('agreements_list');
        Route::get('agreement/create', 'create')->name('agreement_create');
        Route::post('agreement/create', 'store');
        Route::delete('/agreement/delete', 'destroy')->name('agreement_destroy');
        Route::get('/agreement/{any_agreement}/edit', 'edit')->name('agreement_edit');
        Route::post('/agreement/{any_agreement}/edit', 'update');
    });

    Route::get('/organizations', [CNS\AdminOrganizationController::class, 'index'])->name('organizations_list');
    Route::get('/organization/create', [CNS\AdminOrganizationController::class, 'create'])->name('organization_create');
    Route::post('/organization/create', [CNS\AdminOrganizationController::class, 'store']);
    Route::get('/organization/{any_organization}/edit', [CNS\AdminOrganizationController::class, 'edit'])
        ->name('organization_edit');
    Route::post('/organization/{any_organization}/edit', [CNS\AdminOrganizationController::class, 'update']);
    Route::delete('/organization/delete', [CNS\AdminOrganizationController::class, 'destroy'])
        ->name('organization_destroy');

    Route::get('/meetings', [CNS\AdminMeetingController::class, 'index'])->name('meetings_list');
    Route::get('/meeting/create', [CNS\AdminMeetingController::class, 'create'])->name('meeting_create');
    Route::post('/meeting/create', [CNS\AdminMeetingController::class, 'store']);
    Route::get('/meeting/{any_meeting}/edit', [CNS\AdminMeetingController::class, 'edit'])->name('meeting_edit');
    Route::post('/meeting/{any_meeting}/edit', [CNS\AdminMeetingController::class, 'update']);
    Route::delete('/meeting/delete', [CNS\AdminMeetingController::class, 'destroy'])->name('meeting_destroy');

    Route::get('employment-list/', [CNS\AdminEmploymentController::class, 'index'])->name('admin_employment_list');
    Route::get('employment/create', [CNS\AdminEmploymentController::class, 'create'])->name('admin_employment_create');
    Route::post('employment/create', [CNS\AdminEmploymentController::class, 'store']);
    Route::get('/employment/{any_employment}/edit', [CNS\AdminEmploymentController::class, 'edit'])
        ->name('admin_employment_edit');
    Route::post('employment/{any_employment}/edit', [CNS\AdminEmploymentController::class, 'update']);
    Route::delete('/employment/delete', [CNS\AdminEmploymentController::class, 'destroy'])
        ->name('admin_employment_destroy');

    Route::controller(CNS\AdminByLawController::class)->group(function(){
        Route::get('bylaws/', 'index')->name('admin_bylaws_list');
        Route::get('bylaw/create', 'create')->name('admin_bylaw_create');
        Route::post('bylaw/create', 'store');
        Route::get('/bylaw/{any_bylaw}/edit', 'edit')->name('admin_bylaw_edit');
        Route::post('bylaw/{any_bylaw}/edit', 'update');
        Route::delete('/bylaw/delete', 'destroy')->name('admin_bylaw_destroy');
    });

});
