<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminOrganizationController
 */
class AdminOrganizationControllerTest extends TestCase
{
   // use RefreshDatabase;

    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingas($this->admin_user)->get(route('organization_create'));

        $response->assertOk();
        $response->assertViewIs('admin.organization');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {


        $organization = \App\Models\Organization::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('organization_destroy', ['ids' => $organization->id]));

        $response->assertRedirect(route('organizations_list'));
        $this->assertModelMissing($organization);
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminOrganizationController::class,
            'destroy',
            \App\Http\Requests\Organization\DestroyOrganizationRequest::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $organization = \App\Models\Organization::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('organization_edit', $organization->slug));

        $response->assertOk();
        $response->assertViewIs('admin.organization');
        $response->assertViewHas('data');

    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $organizations = \App\Models\Organization::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('organizations_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listorganizations');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $organization = \App\Models\Organization::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/organization/create', [
            'organization' => $organization->toArray()
        ]);

        $this->assertEquals(\Illuminate\Support\Facades\Session::get('success'), 'You have saved a new organization');

    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminOrganizationController::class,
            'store',
            \App\Http\Requests\Organization\StoreOrganizationRequest::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $organization = \App\Models\Organization::factory()->create();

        $response = $this->actingAs($this->admin_user)
          ->post('admin/organization/' .  $organization->slug .'/edit', [
          'organization' => $organization->toArray()
        ]);

        $response->assertRedirect(route('organization_edit', $organization->slug));
    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminOrganizationController::class,
            'update',
            \App\Http\Requests\Organization\UpdateOrganizationRequest::class
        );
    }
}
