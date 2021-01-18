<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider.
 * @property AppServiceProvider $register
 * @property AppServiceProvider $boot
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require app_path('Http/view_helpers.php');

        View::composer('content_feature', 'App\Http\View\Composers\ContentFeature');

        /*
        view()->composer('page_parts.topics', 'App\Http\View\Composers\ViewComposers@topics');
        view()->composer('admin.admin_topics_menu', 'App\Http\View\Composers\ViewComposers@adminTopicsMenu');
         */

        if ($this->app->environment('production')) {
            $urlg = new UrlGenerator();
            $urlg->forceScheme('https');
        }
    }
}
