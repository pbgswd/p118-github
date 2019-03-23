<?php

namespace App\Providers;

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
        require app_path('Http/view_helpers.php');

//        view()->composer('page_parts.topics', 'App\Http\ViewComposers@topics');
//        view()->composer('page_parts.content_feature', 'App\Http\ViewComposers@contentFeature');
//        view()->composer('admin.admin_topics_menu', 'App\Http\ViewComposers@adminTopicsMenu');

        if($this->app->environment('production')) {
            \URL::forceSchema('https');
        }

    }
}
