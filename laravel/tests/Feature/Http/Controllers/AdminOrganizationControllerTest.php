<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminOrganizationController
 */
class AdminOrganizationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $agreements = \App\Models\Agreement::factory()->times(3)->create();

        $response = $this->get(route('organization_create'));

        $response->assertOk();
        $response->assertViewIs('admin.organization');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $organization = \App\Models\Organization::factory()->create();

        $response = $this->delete(route('organization_destroy'));

        $response->assertRedirect(route('organizations_list'));
        $this->assertModelMissing($organizationDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
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
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $organization = \App\Models\Organization::factory()->create();
        $agreements = \App\Models\Agreement::factory()->times(3)->create();

        $response = $this->get(route('organization_edit', ['any_organization' => $any_organization]));

        $response->assertOk();
        $response->assertViewIs('admin.organization');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $organizations = \App\Models\Organization::factory()->times(3)->create();

        $response = $this->get(route('organizations_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listorganizations');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/organization/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('organization_edit', [$org->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
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
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $organization = \App\Models\Organization::factory()->create();

        $response = $this->post('admin/organization/{any_organization}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('organization_edit', [$any_organization->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminOrganizationController::class,
            'update',
            \App\Http\Requests\Organization\UpdateOrganizationRequest::class
        );
    }

    // test cases...
}
