<?php

namespace Tests;

use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Database\Seeders\AccessLevelConstantsSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();

        $this->seed(AccessLevelConstantsSeeder::class);
        $this->seed(RolesAndPermissionsSeeder::class);

        //$this->seed(UserSeeder::class);
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
            ->create();
        $this->user->assignRole('member');

        $this->admin_user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->create();
        $this->admin_user->assignRole(['member', 'super-admin', 'committee']);


        //todo generate fake user resources for other tests to consume
//dd($this->user->toArray());
    }

}
