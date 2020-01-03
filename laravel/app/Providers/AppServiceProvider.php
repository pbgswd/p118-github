<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

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
        //
        require app_path('Http/view_helpers.php');

        /*
        view()->composer('page_parts.topics', 'App\Http\View\Composers\ViewComposers@topics');
        view()->composer('page_parts.content_feature', 'App\Http\View\Composers\ViewComposers@contentFeature');
        view()->composer('admin.admin_topics_menu', 'App\Http\View\Composers\ViewComposers@adminTopicsMenu');
         */

        if($this->app->environment('production')) {
            UrlGenerator::forceScheme('https');
        }

    }
}
