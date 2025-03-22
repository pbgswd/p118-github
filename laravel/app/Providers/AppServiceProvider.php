<?php

namespace App\Providers;

use App\Models\Agreement;
use App\Models\Bylaw;
use App\Models\Carousel;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use App\Models\Employment;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Meeting;
use App\Models\Memoriam;
use App\Models\Motion;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Post;
use App\Models\Qrcode;
use App\Models\Topic;
use App\Models\User;
use App\Models\Venue;
use App\Policies\MotionPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


/**
 * Class AppServiceProvider.
 *
 * @property AppServiceProvider $register
 * @property AppServiceProvider $boot
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/site';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require app_path('Http/view_helpers.php');

        Paginator::useBootstrapFive();

        View::composer('layouts.carousel', \App\Composers\CarouselComposer::class);
        View::composer('content_feature', \App\Composers\ContentFeature::class);
        View::composer('layouts.front-page', \App\Composers\FrontPage::class);
        View::composer('layouts.history-statement', \App\Composers\HistoryBlock::class);

        /*
        view()->composer('page_parts.topics', 'App\Composers\ViewComposers@topics');
        view()->composer('admin.admin_topics_menu', 'App\Composers\ViewComposers@adminTopicsMenu');
         */

        RateLimiter::for('post', function (Request $request) {
            return [
                Limit::perMinute(10)->by(optional($request->email) ?: $request->ip()),
                Limit::perMinute(60),
            ];
        });

        RateLimiter::for('global', function (Request $request) {
            return [
                Limit::perMinute(90)->by($request->ip()),
                Limit::perMinute(1500),
            ];
        });

        RateLimiter::for('download', function (Request $request) {
            return [
                Limit::perMinute(10)->by($request->ip()),
                Limit::perMinute(20),
            ];
        });

        Route::bind('any_agreement', static function ($id) {
            return Agreement::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_bylaw', static function ($id) {
            return Bylaw::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_committee', static function ($slug) {
            return Committee::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_committee_post', static function ($slug) {
            return CommitteePost::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_committee_post_comment', static function ($id) {
            return CommitteePostComment::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_employment', static function ($id) {
            return Employment::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_meeting', static function ($id) {
            return Meeting::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_page', static function ($slug) {
            return Page::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_post', static function ($slug) {
            return Post::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_topic', static function ($slug) {
            return Topic::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_user', static function ($id) {
            return User::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_venue', static function ($slug) {
            return Venue::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_organization', static function ($slug) {
            return Organization::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_policy', static function ($id) {
            return Policy::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_feature', static function ($slug) {
            return Feature::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_memoriam', static function ($slug) {
            return Memoriam::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_faq', static function ($slug) {
            return Faq::withoutGlobalScopes()->where('slug', $slug)->first();
        });
        Route::bind('any_carousel', static function ($id) {
            return Carousel::withoutGlobalScopes()->findOrFail($id);
        });
        Route::bind('any_qrcode', static function ($id) {
            return Qrcode::withoutGlobalScopes()->findOrFail($id);
        });

       Gate::policy(Motion::class, MotionPolicy::class);

        if (! app()->environment('production')) {
            Mail::alwaysTo('superwebdeveloper@gmail.com');
        }
    }
}
