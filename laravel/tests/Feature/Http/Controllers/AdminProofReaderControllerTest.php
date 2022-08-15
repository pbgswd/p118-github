<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminProofReaderController
 */
class AdminProofReaderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $proofreaders = \App\Models\Proofreader::factory()->times(3)->create();

        $response = $this->get(route('admin_proofreader'));

        $response->assertOk();
        $response->assertViewIs('admin.proofreading');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function index_by_entity_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $proofreaders = \App\Models\Proofreader::factory()->times(3)->create();

        $response = $this->post(route('index_by_entity'), [
            // TODO: send request data
        ]);

        $response->assertOk();
        $response->assertViewIs('admin.proofreading');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function sync_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('admin_proofreader_sync'));

        $response->assertRedirect(route('admin_proofreader'));


    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $proofreader = \App\Models\Proofreader::factory()->create();

        $response = $this->post('admin/proofreading/{proofReader}/update', [
            // TODO: send request data
        ]);

        $response->assertOk();


    }


}
