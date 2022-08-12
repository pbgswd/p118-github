<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ExecutiveMembership;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminExecutiveMembershipController
 */
class AdminExecutiveMembershipControllerTest extends TestCase
{
   // use RefreshDatabase;

    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $executives = \App\Models\Executive::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('admin_executive_create', $this->admin_user->id));

        $response->assertOk();
        $response->assertViewIs('admin.executive');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
      $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $executiveMembership = \App\Models\ExecutiveMembership::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_executive_destroy'), ['ids' => $executiveMembership->id]);

        $this->assertModelMissing($executiveMembership);
        $response->assertRedirect(route('admin_executives'));
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminExecutiveMembershipController::class,
            'destroy',
            \App\Http\Requests\Executive\DestroyAdminExecutiveMembership::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $executiveMembership = \App\Models\ExecutiveMembership::factory()->create();
        $executives = \App\Models\Executive::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_executive_edit', $executiveMembership->id));

        $response->assertOk();
        $response->assertViewIs('admin.executive');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');
        $executives = \App\Models\Executive::factory()->times(3)->create();
        $executiveMembership = \App\Models\ExecutiveMembership::factory()->create();
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_executives_list'));

        $response->assertOk();
        $response->assertViewIs('admin.executives_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
       $this->markTestIncomplete( __FUNCTION__ .' has issues.');
        $executiveMembership = \App\Models\ExecutiveMembership::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/user/' . $executiveMembership->id . '/executiveMembership/create', [
                'executive' => $executiveMembership
        ]);
        $response->dumpSession()['errors'];
        $this->assertEquals(Session::get('success'), 'You have created a member executive role');
        //$response->assertRedirect(route('admin_executive_edit', $executiveMembership->id));
    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminExecutiveMembershipController::class,
            'store',
            \App\Http\Requests\Executive\StoreAdminExecutiveMembership::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
       $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $executiveMembership = \App\Models\ExecutiveMembership::factory()->create();

        $data = ExecutiveMembership::first();
        $response = $this->actingAs($this->admin_user)
            ->post('admin/executiveMembership/{executiveMembership}/edit', [
            'executive' => $data->toArray()
        ]);

        $response->assertRedirect(route('admin_executive_edit', $data->id));

    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminExecutiveMembershipController::class,
            'update',
            \App\Http\Requests\Executive\UpdateAdminExecutiveMembership::class
        );
    }
}
