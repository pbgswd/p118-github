<?php

namespace App\Providers;

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
     */
    public function boot(): void
    {
        require app_path('Http/view_helpers.php');

        \Illuminate\Pagination\Paginator::useBootstrap();

        View::composer('layouts.carousel', \App\Composers\CarouselComposer::class);
        View::composer('content_feature', \App\Composers\ContentFeature::class);
        View::composer('layouts.front-page', \App\Composers\FrontPage::class);
        View::composer('layouts.history-statement', \App\Composers\HistoryBlock::class);

        /*
        view()->composer('page_parts.topics', 'App\Composers\ViewComposers@topics');
        view()->composer('admin.admin_topics_menu', 'App\Composers\ViewComposers@adminTopicsMenu');
         */
    }
}
