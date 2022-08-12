<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminPolicyController
 */
class AdminPolicyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('admin_policy_create'));

        $response->assertOk();
        $response->assertViewIs('admin.policy');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $policy = \App\Models\Policy::factory()->create();

        $response = $this->delete(route('admin_policy_destroy'));

        $response->assertRedirect(route('policies_list'));
        $this->assertDeleted($adminPolicyDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPolicyController::class,
            'destroy',
            \App\Http\Requests\Policies\AdminDestroyPolicy::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $policy = \App\Models\Policy::factory()->create();

        $response = $this->get(route('admin_policy_edit', ['any_policy' => $any_policy]));

        $response->assertOk();
        $response->assertViewIs('admin.policy');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $policies = \App\Models\Policy::factory()->times(3)->create();

        $response = $this->get(route('policies_list'));

        $response->assertOk();
        $response->assertViewIs('admin.policies_list');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/policy/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_policy_edit', [$policy->id]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPolicyController::class,
            'store',
            \App\Http\Requests\Policies\AdminStorePolicy::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $policy = \App\Models\Policy::factory()->create();

        $response = $this->post('admin/policy/{any_policy}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_policy_edit', [$any_policy->id]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPolicyController::class,
            'update',
            \App\Http\Requests\Policies\AdminUpdatePolicy::class
        );
    }

    // test cases...
}
