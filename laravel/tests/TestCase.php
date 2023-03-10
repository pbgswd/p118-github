<?php

namespace Tests;

use App\Models\Address;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Database\Seeders\AccessLevelConstantsSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker;
use App\Http\Kernel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Log::debug('TestCase.php -- a test has started');

        Artisan::call('migrate:fresh');

        $this->faker = Faker\Factory::create();
//todo solve why next 2 lines cause issues.
        $this->seed(AccessLevelConstantsSeeder::class); // run when db is schema only
        $this->seed(RolesAndPermissionsSeeder::class);  // run when db is schema only

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
            ->has(Address::factory(), 'address')
            ->create();

        $this->user->assignRole('member');

        $this->admin_user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->create();

        $this->admin_user->assignRole(['member', 'super-admin', 'committee']);
    }

}
