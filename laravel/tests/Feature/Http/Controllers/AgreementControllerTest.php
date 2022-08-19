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
     * @group listok
     */
    public function list_returns_an_ok_response()
    {
        $agreements = \App\Models\Agreement::factory()->times(3)->create();

        $response = $this->get(route('agreements_list_public'));

        $response->assertOk();
        $response->assertViewIs('agreements_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group showok
     */
    public function show_returns_an_ok_response()
    {
        $agreement = \App\Models\Agreement::factory()->create();

        $response = $this->get(route('agreement_show', [$agreement->id]));

        $response->assertOk();
        $response->assertViewIs('agreement_view');
        $response->assertViewHas('data');
    }


}
