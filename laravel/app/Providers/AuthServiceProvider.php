<?php

namespace App\Providers;

use App\Models\Committee;
use App\Models\Employment;
use App\Models\Meeting;
use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\Venue;
use App\Policies\CommitteePolicy;
use App\Policies\EmploymentPolicy;
use App\Policies\MeetingPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\TopicPolicy;
use App\Policies\UserPolicy;
use App\Policies\VenuePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Page::class => PagePolicy::class,
        User::class => UserPolicy::class,
        Topic::class => TopicPolicy::class,
        Venue::class => VenuePolicy::class,
        Committee::class => CommitteePolicy::class,
        Employment::class => EmploymentPolicy::class,
        Meeting::class => MeetingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
