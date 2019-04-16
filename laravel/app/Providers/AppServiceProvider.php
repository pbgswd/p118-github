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

        /*
         *
         *
         *        $this->registerPolicies();

        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
         *
         *
         * */


        if($this->app->environment('production')) {
            URL::forceSchema('https');
        }

    }
}
