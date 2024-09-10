<?php

use App\Http\Controllers as CNS;
use App\Http\Middleware\CheckMessagingFeatureStatus;
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

    Route::permanentRedirect('/apply.html', '/page/apply-for-overhire-work');

    //Route::get('sendemail', [CNS\MailController::class, 'index']);

    Route::get('/', [CNS\HelloController::class, 'index'])->name('hello');

    Route::get('contact', [CNS\ContactController::class, 'show'])->name('contact');
    Route::post('contact', [CNS\ContactController::class, 'submit']);

    Route::get('carousel', [CNS\CarouselController::class, 'show'])->name('carousel');

    Route::get('memoriams', [CNS\MemoriamController::class, 'index'])->name('memoriam_list');
    Route::get('memoriam/{memoriam}', [CNS\MemoriamController::class, 'show'])->name('memoriam');

    Route::get('executive', [CNS\ExecutiveController::class, 'index'])->name('executive');

    //Route::get('/hire-us', [CNS\HireUsController::class, 'show'])->name('hire-us'); // to be updated

    Route::controller(CNS\PageController::class)->group(function () {
       // Route::redirect('/page/apply-for-overhire-work', '/page/not-accepting-new-hire-applications');
        Route::get('/pages', 'list')->name('pages');
        Route::get('/page/{page}', 'show')->name('page_show');
    });

    Route::get('/topics', [CNS\TopicController::class, 'list'])->name('topics');
    Route::get('/topic/{topic}', [CNS\TopicController::class, 'show'])->name('topic_show');

    Route::controller(CNS\PostController::class)->group(function () {
        Route::get('/posts', 'list')->name('posts');
        Route::get('/post/{post}', 'show')->name('post_show');
    });

    Route::controller(CNS\InviteUserController::class)->group(function () {
        Route::get('/site_invitation/{inviteUser}/{password}', 'show')->name('invite_user_signup');
        Route::post('/site_invitation/{inviteUser}/{password}', 'process_user')->name('public_process_invitation');
    });

    Route::get('/venues', [CNS\VenueController::class, 'list'])->name('venues');
    Route::get('/venue/{venue}', [CNS\VenueController::class, 'show'])->name('venue');

    Route::get('/organizations', [CNS\OrganizationController::class, 'list'])->name('organizations');
    Route::get('/organization/{organization}', [CNS\OrganizationController::class, 'show'])->name('organization');

    Route::get('agreements', [CNS\AgreementController::class, 'list'])->name('agreements_list_public');
    Route::get('/agreement/{agreement}', [CNS\AgreementController::class, 'show'])->name('agreement_show');

    Route::get('bylaws', [CNS\ByLawController::class, 'list'])->name('bylaws_list_public');
    Route::get('/bylaw/{bylaw}', [CNS\ByLawController::class, 'show'])->name('bylaw_show');

    Route::controller(CNS\FaqController::class)->group(function () {
        Route::get('/faqs', 'index')->name('faqs_list_public');
        Route::get('/faq/{any_faq}', 'show')->name('faq_show');
    });

    Route::controller(CNS\PostController::class)->group(function () {
        Route::get('/posts', 'list')->name('posts');
        Route::get('/post/{post}', 'show')->name('post_show');
    });

    Route::get('/{folder}/download/{attachment}', [CNS\AttachmentController::class, 'download'])
        ->name('attachment_download')->middleware('throttle:download');
});

/**
 * MEMBERS LOGGED IN
 */
Route::middleware('web', 'auth')->group(function () {
    Route::get('/site', [CNS\SiteController::class, 'index'])->name('landing_page');

    Route::get('/home', [CNS\HomeController::class, 'index'])->name('home'); // redirects to home page

    Route::controller(CNS\EmploymentController::class)->group(function () {
        Route::post('jobs', 'jobs_year')->name('jobs_year');
        Route::get('jobs/{deadline}', 'index_by_year')->name('list_jobs_year');
        Route::get('jobs', 'index')->name('jobs_list');
        Route::get('job/{employment}', 'show')->name('job_view');
    });

    Route::get('features', [CNS\FeatureController::class, 'index'])->name('features');
    Route::get('feature/{feature}', [CNS\FeatureController::class, 'show'])->name('feature');

    Route::controller(CNS\MessageController::class)->group(function () {
        Route::get('messages', 'index')->name('messages')->middleware(CheckMessagingFeatureStatus::class);
        Route::get('message/{message}', 'show')->name('message')->middleware(CheckMessagingFeatureStatus::class);
        Route::post('member/{user}/message_preferences', 'update')->name('update_message_preferences')->middleware(CheckMessagingFeatureStatus::class);
    });

    Route::controller(CNS\UserController::class)->group(function () {
        Route::get('/members', 'index')->name('members');
        Route::get('/member/{user}', 'show')->name('member');
        Route::get('/member/{user}/edit', 'edit')->name('member_edit');
        Route::post('/member/{user}/edit', 'update');
        Route::get('/member/{user}/address/edit', 'edit_address')->name('member_address_edit');
        Route::post('/member/{user}/address/edit', 'update_address')->name('update_address');
        Route::get('/member/{user}/emergency_contact/edit', 'edit_emergency_contact')->name('edit_emergency_contact');
        Route::post('/member/{user}/emergency_contact/edit', 'update_emergency_contact')->name('update_emergency_contact');
        Route::get('/member/{user}/password', 'edit_password')->name('member_password_edit');
        Route::post('/member/{user}/password', 'update_password')->name('member_password_update');
    });

    Route::get('policies', [CNS\PolicyController::class, 'index'])->name('policies_list_public');
    Route::get('/policies/{policy}', [CNS\PolicyController::class, 'show'])->name('policy_show_public');

    Route::get('committees', [CNS\CommitteeController::class, 'index'])->name('committees');
    Route::get('committee/{committee}', [CNS\CommitteeController::class, 'show'])->name('committee');

    Route::controller(CNS\CommitteePostController::class)->group(function () {
        Route::get('committee/{committee}/post/create', 'create')->name('committee_add_public_post');
        Route::post('committee/{committee}/post/create', 'store')->name('committee_store_public_post');
        Route::get('committee/{committee}/post/{committeePost}', 'show')->name('public_committee_post_show');
        Route::get('committee/{committee}/post/{committeePost}/edit', 'edit')->name('committee_post_edit_form');

        Route::post('committee/{committee}/post/{any_committee_post}/edit', 'update')
            ->name('committee_update_public_post');

        Route::delete('committee/{committee}/post/{committeePost}/destroy', 'destroy')
            ->name('public_committee_post_destroy');
    });

    Route::controller(CNS\MeetingController::class)->group(function () {
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

    Route::controller(CNS\AdminController::class)->group(function () {
        Route::get('/', 'index')->name('admin');
        Route::get('/blank', 'blank')->name('blank');
        Route::get('/developer', 'developer')->name('developer');
        Route::get('/developer/phpinfo', 'getphpinfo')->name('phpinfo');
        Route::get('/development', 'development')->name('development');
    });

    Route::controller(CNS\AdminMessageController::class)->group(function () {
        Route::get('messages', 'index')->name('admin_messages')->middleware(CheckMessagingFeatureStatus::class);
        Route::get('message/create', 'create')->name('admin_message_create')->middleware(CheckMessagingFeatureStatus::class);
        Route::post('message/create', 'store')->name('admin_message_store')->middleware(CheckMessagingFeatureStatus::class);

        Route::get('message/{message}/edit', 'edit')->name('admin_message_edit')->middleware(CheckMessagingFeatureStatus::class);
        Route::post('message/{message}/edit', 'update')->name('admin_message_update')->middleware(CheckMessagingFeatureStatus::class);

        Route::get('message/{message}/preview', 'preview')->name('admin_message_preview')->middleware(CheckMessagingFeatureStatus::class);
        Route::get('message/{message}/preview_strict', 'preview_strict')->name('admin_message_preview_strict')->middleware(CheckMessagingFeatureStatus::class);
        Route::get('message/{message}/send', 'send')->name('admin_message_send')->middleware(CheckMessagingFeatureStatus::class);
        Route::delete('message/delete', 'destroy')->name('admin_message_destroy')->middleware(CheckMessagingFeatureStatus::class);
    });

    Route::controller(CNS\AdminEmailQueueController::class)->group(function () {
        Route::get('email_queue', 'index')->name('admin_email_queue_list')->middleware(CheckMessagingFeatureStatus::class);
        Route::get('email_queue/{email_queue}/message', 'show')->name('admin_email_queue_show')->middleware(CheckMessagingFeatureStatus::class);
        Route::delete('email_queue/delete', 'destroy')->name('admin_email_queue_destroy')->middleware(CheckMessagingFeatureStatus::class);
    });

    Route::controller(CNS\AdminCarouselController::class)->group(function () {
        Route::get('carousel', 'index')->name('admin_carousel_list');
        Route::get('carousel/create', 'create')->name('admin_carousel_create');
        Route::post('carousel/create', 'store')->name('admin_carousel_store');
        Route::get('carousel/{any_carousel}/edit', 'edit')->name('admin_carousel_edit');
        Route::post('carousel/{any_carousel}/edit', 'update')->name('admin_carousel_update');
        Route::delete('carousel/delete', 'destroy')->name('admin_carousel_destroy');
    });

    Route::controller(CNS\AdminMemoriamController::class)->group(function () {
        Route::get('memoriams', 'index')->name('admin_memoriam_list');
        Route::get('memoriam/create', 'create')->name('admin_memoriam_create');
        Route::post('memoriam/create', 'store');
        Route::get('memoriam/{any_memoriam}/edit', 'edit')->name('admin_memoriam_edit');
        Route::post('memoriam/{any_memoriam}/edit', 'update');
        Route::delete('memoriam/delete', 'destroy')->name('admin_memoriam_destroy');
    });

    Route::controller(CNS\AdminProofReaderController::class)->group(function () {
        Route::get('proofreading-sync', 'sync')->name('admin_proofreader_sync');
        Route::get('proofreading', 'index')->name('admin_proofreader');
        Route::post('proofreading', 'index_by_entity')->name('index_by_entity');
        Route::post('proofreading/{proofReader}/update', 'update');
    });

    Route::controller(CNS\LocalSearchController::class)->group(function () {
        Route::post('/search', 'admin_search')->name('admin_search');
        //Route::get('/search','admin_index')->name('admin_search_show');
        Route::post('/attachment_search', 'admin_attachment_search')
            ->name('list_attachments_search_result');
    });

    Route::controller(CNS\AdminFeatureController::class)->group(function () {
        Route::get('features', 'index')->name('admin_features_list');
        Route::get('feature/create', 'create')->name('admin_feature_create');
        Route::post('feature/create', 'store');
        Route::get('feature/{any_feature}/edit', 'edit')->name('admin_feature_edit');
        Route::post('feature/{any_feature}/edit', 'update');
        Route::delete('feature/delete', 'destroy')->name('admin_feature_destroy');
    });

    Route::controller(CNS\AdminPolicyController::class)->group(function () {
        Route::get('/policies', 'index')->name('policies_list');
        Route::get('/policy/create', 'create')->name('admin_policy_create');
        Route::post('/policy/create', 'store');
        Route::get('/policy/{any_policy}/edit', 'edit')->name('admin_policy_edit');
        Route::post('/policy/{any_policy}/edit', 'update');
        Route::delete('/policy/delete', 'destroy')->name('admin_policy_destroy');
    });

    Route::controller(CNS\AdminTopicController::class)->group(function () {
        Route::get('/topics', 'index')->name('topics_list');
        Route::get('/topic/create', 'create')->name('topic_create');
        Route::post('/topic/create', 'store');
        Route::get('/topic/{any_topic}/edit', 'edit')->name('topic_edit');
        Route::post('/topic/{any_topic}/edit', 'update');
        Route::delete('/topic/delete', 'destroy')->name('topic_destroy');
    });

    Route::controller(CNS\AdminUserController::class)->group(function () {
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

    Route::controller(CNS\AdminExecutiveController::class)->group(function () {
        Route::get('/executives', 'index')->name('admin_executives_list');
        Route::get('/user/{user}/executive/create', 'create')->name('admin_executive_create');
        Route::post('/user/{user}/executive/create', 'store')->name('admin_executive_store');
        Route::get('/executive/{executive}/edit', 'edit')->name('admin_executive_edit');
        Route::post('/executive/{executive}/edit', 'update')->name('admin_executive_update');
        Route::delete('executives/delete', 'destroy')->name('admin_executive_destroy');
    });

    Route::controller(CNS\InviteUserController::class)->group(function () {
        Route::get('/invite-new-user', 'create')->name('invite-new-user');
        Route::post('/invite-new-user', 'store')->name('store_invited_user');
        Route::get('/invited_users', 'index')->name('admin_list_invited_users');
        Route::get('/invited_user/{inviteUser}', 'show')->name('show_invited_user');
        //Route::get('/invitation-mailmsg' 'mail')->name('mail_invited_user');
        Route::delete('/invited_user/delete', 'destroy')->name('invited_user_destroy');
        Route::get('/invite_import-list', 'list_import')->name('list_import');
        Route::get('process_import_invitation', 'process_import_invitation')
            ->name('process_import_invitation');
    });

    Route::get('/invite-resend-list', [CNS\ReInviteUserController::class, 'index'])->name('invite-resend-list');

    Route::controller(CNS\AdminPageController::class)->group(function () {
        Route::get('/pages', 'index')->name('pages_list');
        Route::get('/page/create', 'create')->name('page_create');
        Route::post('/page/create', 'store');
        Route::get('/page/{any_page}/edit', 'edit')->name('page_edit');
        Route::post('/page/{any_page}/edit', 'update')->name('admin_update_page');
        Route::delete('/page/delete', 'destroy')->name('page_destroy');
    });

    Route::controller(CNS\AdminPostController::class)->group(function () {
        Route::get('/posts', 'index')->name('posts_list');
        Route::get('/post/create', 'create')->name('post_create');
        Route::post('/post/create', 'store');
        Route::get('/post/{any_post}/edit', 'edit')->name('post_edit');
        Route::post('/post/{any_post}/edit', 'update');
        Route::delete('/post/delete', 'destroy')->name('post_destroy');
        Route::get('/post/{any_post}/message', 'message')->name('admin_post_message');
    });

    Route::controller(CNS\AttachmentController::class)->group(function () {
        Route::get('/attachments', 'index')->name('attachments_list');
        Route::get('/attachments_icons', 'index_icons')->name('attachments_icons_list');
        Route::post('/attachments_ajax_upload', 'ajax_upload')->name('ajax_upload');
        Route::get('/attachments/endless', 'endless' )->name('endless');
        Route::get('/attachments/endless/data', 'endless_data' )->name('endless_data');
        Route::get('/attachment/create', 'create')->name('attachment_create');
        Route::post('/attachment/create', 'store')->name('create_attachment');
        Route::get('/attachment/{attachment}/edit', 'edit')->name('admin_attachment_edit');
        Route::post('/attachment/{attachment}/edit', 'update');
        Route::delete('/attachment/delete', 'destroy')->name('attachment_destroy');
    });

    Route::get('/roles', [CNS\RoleController::class, 'index'])->name('roles_list');

    Route::controller(CNS\AdminVenueController::class)->group(function () {
        Route::get('/venues', 'index')->name('venues_list');
        Route::get('/venue/create', 'create')->name('venue_create');
        Route::post('/venue/create', 'store');
        Route::get('/venue/{any_venue}/edit', 'edit')->name('venue_edit');
        Route::post('/venue/{any_venue}/edit', 'update');
        Route::delete('/venue/delete', 'destroy')->name('venue_destroy');
    });

    Route::controller(CNS\AdminCommitteeMemberController::class)->group(function () {
        Route::post('committee/{committee}/admin-list-committee-members', 'search')
            ->name('admin_search_committee_members');

        Route::get('committee/{committee}/admin-list-committee-members', 'index')->name('admin-list-committee-members');

        Route::get('committee/{committee}/admin-create-committee-members/user/{user}', 'create')
            ->name('admin_create_committee_members');
        Route::post('committee/{committee}/admin-create-committee-members/user/{user}', 'store');
        Route::get('committee/{committee}/admin-edit-committee-members/user/{user}', 'edit')
            ->name('admin_edit_committee_members');
        Route::post('committee/{committee}/admin-edit-committee-members/user/{user}', 'update')
            ->name('admin_update_committee_member');
        //todo
        Route::delete('committee/{committee}/user/{user}/delete', 'destroy')
            ->name('admin_delete-committee_member');
    });

    Route::controller(CNS\AdminCommitteeController::class)->group(function () {
        Route::get('committees', 'index')->name('committees_list');
        Route::get('committee/create', 'create')->name('committee_create');
        Route::post('committee/create', 'store');
        Route::get('committee/{any_committee}/show', 'show')->name('admin_committee_show');
        Route::get('committee/{any_committee}/edit', 'edit')->name('committee_edit');
        Route::post('committee/{any_committee}/edit', 'update')->name('admin_committee_update');
        Route::delete('committee/delete', 'destroy')->name('committee_destroy');
    });

    Route::controller(CNS\AdminCommitteePostController::class)->group(function () {
        Route::get('committee/{committee}/posts', 'index')->name('committee_posts_list');
        Route::get('committee/{committee}/post/create', 'create')->name('admin_committee_post');
        Route::post('committee/{committee}/post/create', 'store');
        Route::get('committee/{committee}/post/{any_committee_post}/edit', 'edit')->name('admin_committee_post_edit');
        Route::post('committee/{committee}/post/{any_committee_post}/edit', 'update');
        Route::delete('committee/{committee}/post/delete', 'destroy')->name('committee_post_destroy');
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

    Route::controller(CNS\AdminAgreementController::class)->group(function () {
        Route::get('agreements', 'index')->name('agreements_list');
        Route::get('agreement/create', 'create')->name('agreement_create');
        Route::post('agreement/create', 'store');
        Route::delete('/agreement/delete', 'destroy')->name('agreement_destroy');
        Route::get('/agreement/{any_agreement}/edit', 'edit')->name('agreement_edit');
        Route::post('/agreement/{any_agreement}/edit', 'update');
    });

    Route::controller(CNS\AdminOrganizationController::class)->group(function () {
        Route::get('/organizations', 'index')->name('organizations_list');
        Route::get('/organization/create', 'create')->name('organization_create');
        Route::post('/organization/create', 'store');
        Route::get('/organization/{any_organization}/edit', 'edit')->name('organization_edit');
        Route::post('/organization/{any_organization}/edit', 'update');
        Route::delete('/organization/delete', 'destroy')->name('organization_destroy');
    });

    Route::controller(CNS\AdminMeetingController::class)->group(function () {
        Route::get('/meetings', 'index')->name('meetings_list');
        Route::get('/meeting/create', 'create')->name('meeting_create');
        Route::post('/meeting/create', 'store');
        Route::get('/meeting/{any_meeting}/edit', 'edit')->name('meeting_edit');
        Route::post('/meeting/{any_meeting}/edit', 'update');
        Route::delete('/meeting/delete', 'destroy')->name('meeting_destroy');
    });

    Route::controller(CNS\AdminEmploymentController::class)->group(function () {
        Route::get('employment-list/', 'index')->name('admin_employment_list');
        Route::get('employment/create', 'create')->name('admin_employment_create');
        Route::post('employment/create', 'store');
        Route::get('/employment/{any_employment}/edit', 'edit')
            ->name('admin_employment_edit');
        Route::post('employment/{any_employment}/edit', 'update')->name('admin_employment_update');
        Route::delete('/employment/delete', 'destroy')
            ->name('admin_employment_destroy');
    });

    Route::controller(CNS\AdminByLawController::class)->group(function () {
        Route::get('bylaws/', 'index')->name('admin_bylaws_list');
        Route::get('bylaw/create', 'create')->name('admin_bylaw_create');
        Route::post('bylaw/create', 'store');
        Route::get('/bylaw/{any_bylaw}/edit', 'edit')->name('admin_bylaw_edit');
        Route::post('bylaw/{any_bylaw}/edit', 'update');
        Route::delete('/bylaw/delete', 'destroy')->name('admin_bylaw_destroy');
    });

    Route::controller(CNS\AdminQrCodeController::class)->group(function () {
        Route::get('qrcodes/', 'index')->name('admin_qrcodes_list');
        Route::get('qrcode/create', 'create')->name('admin_qrcode_create');
        Route::post('qrcode/create', 'store');
        Route::get('/qrcode/{any_qrcode}/edit', 'edit')->name('admin_qrcode_edit');
        Route::post('qrcode/{any_qrcode}/edit', 'update');
        Route::delete('/qrcode/delete', 'destroy')->name('admin_qrcode_destroy');
        Route::get('/qrcode/{any_qrcode}/download/', 'download')
            ->name('qrcode_download')->middleware('throttle:download');
    });

    Route::controller(CNS\AdminFaqController::class)->group(function () {
        Route::get('faqs/', 'index')->name('admin_faqs_list');
        Route::get('faq/create', 'create')->name('admin_faq_create');
        Route::post('faq/create', 'store');
        Route::get('/faq/{any_faq}/edit', 'edit')->name('admin_faq_edit');
        Route::post('faq/{any_faq}/edit', 'update');
        Route::delete('/faq/delete', 'destroy')->name('admin_faq_destroy');
    });
});
