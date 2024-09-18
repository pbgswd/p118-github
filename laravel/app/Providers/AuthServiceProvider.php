<?php

namespace App\Providers;

use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Bylaw;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\Employment;
use App\Models\Executive;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\InviteUser;
use App\Models\Meeting;
use App\Models\Memoriam;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\Venue;
use App\Policies\AgreementPolicy;
use App\Policies\AttachmentPolicy;
use App\Policies\BylawPolicy;
use App\Policies\CommitteePolicy;
use App\Policies\CommitteePostPolicy;
use App\Policies\EmploymentPolicy;
use App\Policies\ExecutivePolicy;
use App\Policies\FaqPolicy;
use App\Policies\FeaturePolicy;
use App\Policies\InviteUserPolicy;
use App\Policies\MeetingPolicy;
use App\Policies\MemoriamPolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\PagePolicy;
use App\Policies\PolicyPolicy;
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
        Post::class => PostPolicy::class,
        Page::class => PagePolicy::class,
        Topic::class => TopicPolicy::class,
        Venue::class => VenuePolicy::class,
        Employment::class => EmploymentPolicy::class,
        Meeting::class => MeetingPolicy::class,
        Agreement::class => AgreementPolicy::class,
        Bylaw::class => BylawPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Executive::class => ExecutivePolicy::class,
        Policy::class => PolicyPolicy::class,
        Committee::class => CommitteePolicy::class,
        CommitteePost::class => CommitteePostPolicy::class,
        Attachment::class => AttachmentPolicy::class,
        Feature::class => FeaturePolicy::class,
        Memoriam::class => MemoriamPolicy::class,
        Faq::class => FaqPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void {}
}
