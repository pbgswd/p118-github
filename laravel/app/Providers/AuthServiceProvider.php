<?php

namespace App\Providers;

use App\Models\Page;
use App\Policies\PagePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Page::class => PagePolicy::class,
        //User::class => UserPolicy::class; // todo
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(PagePolicy $gate)
    {
        //GateContract $gate
        $this->registerPolicies($gate);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        /*
         *
        // Implicitly grant "super-admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
         */
    }
}
