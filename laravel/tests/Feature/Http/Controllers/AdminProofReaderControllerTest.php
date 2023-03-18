<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Proofreader;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminProofReaderController
 */
class AdminProofReaderControllerTest extends TestCase
{
    //

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $proofreaders = \App\Models\Proofreader::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_proofreader'));

        $response->assertOk();
        $response->assertViewIs('admin.proofreading');
        $response->assertViewHas('data');


    }

    /**
     * @test
     * @group entityok
     */
    public function index_by_entity_returns_an_ok_response()
    {
        $proof = Proofreader::factory()->make();

        $types = ['CommitteePost', 'Post', 'Meeting', 'Feature'];
        shuffle($types);

        $response = $this->actingAs($this->admin_user)
            ->post(route('index_by_entity'), [
            'type' => $types[0],
        ]);

        $response->assertOk();
        $response->assertViewIs('admin.proofreading');
        $response->assertViewHas('data');

    }

    /**
     * @test
     * @group syncok
     */
    public function sync_returns_an_ok_response()
    {

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_proofreader_sync'));

        $response->assertRedirect(route('admin_proofreader'));
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {

        $types = ['CommitteePost', 'Post', 'Meeting', 'Feature'];
        shuffle($types);

        $proofreader = \App\Models\Proofreader::factory()->create();
        $proof = Proofreader::first();

        $data = [
            'type'  =>  $types[0],
            'pr' => [
                'type' => $types[0]
            ]
        ];

        $response = $this->actingAs($this->admin_user)
            ->post('admin/proofreading/' . $proof->id .'/update', [
            $data
        ]);

        $response->assertOk();
    }
}
