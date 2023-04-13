<?php

namespace Tests;

use App\Models\Address;

use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\ExecutiveMembership;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Database\Seeders\AccessLevelConstantsSeeder;
use Database\Seeders\ExecutiveSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

Log::debug('==============================================');
Log::debug('TestCase.php -- a test has started');

        DB::connection()->enableQueryLog();

        Artisan::call('cache:clear');
        Artisan::call('migrate:fresh');

        $this->faker = Faker\Factory::create();

        $this->seed(AccessLevelConstantsSeeder::class); // run when db is schema only
        $this->seed(RolesAndPermissionsSeeder::class);  // run when db is schema only
        $this->seed(ExecutiveSeeder::class);

        $this->users = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->count(3)
            ->create();

        $this->user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->has(Address::factory(), 'address')
            ->create();

        $this->user->assignRole('member');

        $this->executive_user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->has(Address::factory(), 'address')
            ->create();
        $this->executive_user->assignRole('member');

        $executive = new ExecutiveMembership(
            [
                'executive_id' => 1,
                'start_date' => date('Y-m-d'),
                'end_date' => date('d-m-Y', strtotime('+1 year'))
            ]
        );
        $executive->user_id = $this->executive_user->id;
        $executive->current = $executive->end_date->isPast() ? 0 : 1;
        $executive->save();
        $this->executive_user->load('executive_role');

        $this->admin_user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->create();

        $this->admin_user->assignRole(['member', 'super-admin', 'committee']);

        $this->committee_member = User::factory()
            ->has(Membership::factory(),'membership')
            ->create();
        $this->committee_member->assignRole('member');

        $this->committee_admin_user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->create();

        $this->committee_admin_user->assignRole(['super-admin', 'member', 'committee']);

        $this->committee = Committee::factory()->create(['user_id' => $this->committee_admin_user->id]);


        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_create_committee_members', [$this->committee, $this->committee_member]),
                [
                    'role' => 'Member'
                ]);

//todo committee posts
        $this->committeePost = CommitteePost::factory()
            ->create(['committee_id' => $this->committee->id, 'user_id' => $this->committee_member->id]);
        $this->committeePosts = CommitteePost::factory()
            ->times(3)
            ->create(['committee_id' => $this->committee->id, 'user_id' => $this->committee_member->id]);

Log::debug("End of setUp");
Log::debug('==============================================');
    }
}
