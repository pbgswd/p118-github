<?php

namespace App\Providers;

use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\Employment;
use App\Models\InviteUser;
use App\Models\Meeting;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\Venue;
use App\Policies\AgreementPolicy;
use App\Policies\AttachmentPolicy;
use App\Policies\CommitteePolicy;
use App\Policies\CommitteePostPolicy;
use App\Policies\EmploymentPolicy;
use App\Policies\InviteUserPolicy;
use App\Policies\MeetingPolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\TopicPolicy;
use App\Policies\UserPolicy;
use App\Policies\VenuePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        InviteUser::class => InviteUserPolicy::class,
        User::class => UserPolicy::class,
        CommitteePost::class => CommitteePostPolicy::class,

        Post::class => PostPolicy::class,
        Page::class => PagePolicy::class,
        Topic::class => TopicPolicy::class,
        Venue::class => VenuePolicy::class,
        Committee::class => CommitteePolicy::class,
        Employment::class => EmploymentPolicy::class,
        Meeting::class => MeetingPolicy::class,
        Agreement::class => AgreementPolicy::class,
        Attachment::class => AttachmentPolicy::class,
        Organization::class => OrganizationPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //todo gate stuff
    }
}
