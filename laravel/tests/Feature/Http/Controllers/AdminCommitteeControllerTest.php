<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Committee;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\AdminCommitteeController
 */
class AdminCommitteeControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('committee_create'));

        $response->assertOk();
        $response->assertViewIs('admin.committee');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->committee_admin_user)
            ->delete(route('committee_destroy'), ['id' => $this->committee->id]);

        $this->assertModelMissing($this->committee);
        $response->assertRedirect(route('committees_list'));
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminCommitteeController::class,
            'destroy',
            \App\Http\Requests\Committees\DestroyCommitteeRequest::class
        );
    }

    /**
     * @test
     *
     * @group editok
     */
    public function edit_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('committee_edit', $this->committee->slug));

        $response->assertOk();
        $response->assertViewIs('admin.committee');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('committees_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listcommittees');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group showok
     */
    public function show_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_committee_show', ['any_committee' => $this->committee->slug]));

        $response->assertOk();
        $response->assertViewIs('admin.show_committee');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $committee = Committee::factory()
            ->make(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->admin_user)
            ->post('admin/committee/create', [
                'committee' => $committee->toArray(),
            ]);

        $this->assertEquals(Session::get('success'), 'You have created a new committee, '.$committee->name);
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminCommitteeController::class,
            'store',
            \App\Http\Requests\Committees\StoreCommitteeRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        $data = Committee::find($this->committee->id);

        $data = [
            'slug' => $data->slug,
            'name' => 'bla bla '.$data->name,
            'description' => 'Update to description '.$data->description,
            'email' => $data->email,
            'live' => $data->live,
        ];

        $response = $this->actingAs($this->committee_admin_user)
            ->post(route('admin_committee_update', $data['slug']), [
                'committee' => $data,
            ]);

        $committee = Committee::find($this->committee->id);

        $response->assertRedirect(route('committee_edit', $committee->slug));

    }

    /**
     * @test
     *
     *  @group updateok
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminCommitteeController::class,
            'update',
            \App\Http\Requests\Committees\UpdateCommitteeRequest::class
        );
    }
}
