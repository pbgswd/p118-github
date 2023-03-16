<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Agreement;
use App\Models\Organization;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminAgreementController
 */
class AdminAgreementControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function create_returns_an_ok_response()
    {
        $response =  $this->actingAs($this->admin_user)->get(route('agreement_create'));

        $response->assertOk();
        $response->assertViewIs('admin.agreement');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     */
    public function destroy_returns_an_ok_response()
    {
        $agreement = \App\Models\Agreement::factory()->create();
        $response = $this->actingAs( $this->admin_user)
            ->delete(route('agreement_destroy'), ['ids' => $agreement->id]);
        $this->assertModelMissing($agreement);
        $response->assertRedirect(route('agreements_list'));
    }

    /**
     * @test
     *
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminAgreementController::class,
            'destroy',
            \App\Http\Requests\Agreements\DestroyAgreementRequest::class
        );
    }

    /**
     * @test
     *
     */
    public function edit_returns_an_ok_response()
    {
        $agreement = \App\Models\Agreement::factory()
            ->has(Organization::factory()->times(3))
            ->has(Venue::factory()->times(3))->create();

        $response = $this->actingAs($this->admin_user)->get(route('agreement_edit', $agreement->id));

        $response->assertOk();
        $response->assertViewIs('admin.agreement');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     */
    public function index_returns_an_ok_response()
    {
        $agreements = \App\Models\Agreement::factory()
            ->has(Organization::factory()->times(3))
            ->has(Venue::factory()->times(3))
            ->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('agreements_list'));

        $response->assertOk();
        $response->assertViewIs('admin.agreements_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     */
    public function store_returns_an_ok_response()
    {
        $agreement = \App\Models\Agreement::factory()
            ->has(Organization::factory()->times(3))
            ->has(Venue::factory()->times(3))
            ->make();

        $response = $this->actingAs($this->admin_user)->post(env('APP_URL') . '/admin/agreement/create',
            [
                'agreement' => $agreement->toArray()
            ]);

       $this->assertEquals(Session::get('success'), 'agreement posting saved');
    }

    /**
     * @test
     *
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminAgreementController::class,
            'store',
            \App\Http\Requests\Agreements\StoreAgreementRequest::class
        );
    }

    /**
     * @test
     * @group admin_update
     */
    public function update_returns_an_ok_response()
    {
        $agreement = \App\Models\Agreement::factory()->create();

        $data = Agreement::first();

        $data['description'] = 'Modified agreement description text ' . $data->description;

        $response = $this->actingAs($this->admin_user)->post('admin/agreement/' . $data->id . '/edit', [
            'agreement' => $data->toArray()
        ]);

        $response->assertRedirect(route('agreement_edit', ['any_agreement' =>$data->id]));
    }

    /**
     * @test
     *
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminAgreementController::class,
            'update',
            \App\Http\Requests\Agreements\UpdateAgreementRequest::class
        );
    }
}
