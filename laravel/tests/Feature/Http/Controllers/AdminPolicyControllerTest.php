<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Policy;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminPolicyController
 */
class AdminPolicyControllerTest extends TestCase
{
    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin_policy_create'));

        $response->assertOk();
        $response->assertViewIs('admin.policy');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $policy = \App\Models\Policy::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_policy_destroy', ['id' => $policy->id]));

        $response->assertRedirect(route('policies_list'));
        $this->assertModelMissing($policy);
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
     *
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $policy = \App\Models\Policy::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_policy_edit', $policy->id));

        $response->assertOk();
        $response->assertViewIs('admin.policy');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $policies = \App\Models\Policy::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('policies_list'));

        $response->assertOk();
        $response->assertViewIs('admin.policies_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $policy = \App\Models\Policy::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/policy/create', [
                'policy' => $policy->toArray(),
            ]);
        $this->assertEquals(Session::get('success'), 'policy posting saved');
    }

    /**
     * @test
     *
     * @group storeok
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
     *
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $policy = \App\Models\Policy::factory()->create();

        $data = Policy::first();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/policy/'.$data->id.'/edit', [
                'policy' => $data->toArray(),
            ]);

        $response->assertRedirect(route('admin_policy_edit', $data->id));
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPolicyController::class,
            'update',
            \App\Http\Requests\Policies\AdminUpdatePolicy::class
        );
    }
}
