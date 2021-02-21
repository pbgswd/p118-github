<?php

namespace App\Providers;

use App\Models\Agreement;
use App\Models\Bylaw;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use App\Models\Employment;
use App\Models\Feature;
use App\Models\Meeting;
use App\Models\Memoriam;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
   // protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        parent::boot();

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
        //todo remove scope venue, organization
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
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     * namespace commented out in Laravel 8 Spark upgrade
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             //->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     * namespace commented out in Laravel 8 Spark upgrade
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             //->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
