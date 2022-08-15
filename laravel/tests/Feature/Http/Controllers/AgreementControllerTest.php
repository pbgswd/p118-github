<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\AccessLevelConstantsSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AgreementController
 */
class AgreementControllerTest extends TestCase
{
   //use RefreshDatabase;

    /**
     * @test
     */
    public function list_returns_an_ok_response()
    {
      //$this->markTestIncomplete( __FUNCTION__ .' has issues.');

        app(DatabaseSeeder::class)->call(UserSeeder::class);
        app(DatabaseSeeder::class)->call(AccessLevelConstantsSeeder::class);

        $agreements = \App\Models\Agreement::factory()->times(3)->create();

        $response = $this->get(route('agreements_list_public'));

        $response->assertOk();
        $response->assertViewIs('agreements_list');
        $response->assertViewHas('data');



        // todo: is there pagination and does it work? or not visible when not needed
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');
//todo not working?? user constraint issue
        app(DatabaseSeeder::class)->call(AccessLevelConstantsSeeder::class);
        $agreement = \App\Models\Agreement::factory()->create();

        $response = $this->get(route('agreement_show', [$agreement]));

        $response->assertOk();
        $response->assertViewIs('agreement_view');
        $response->assertViewHas('data');



        // todo: a file attachment? is it there? Can I download it?
    }


}
