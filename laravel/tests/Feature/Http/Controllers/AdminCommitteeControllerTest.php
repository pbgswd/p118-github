<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Committee;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminCommitteeController
 */
class AdminCommitteeControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('committee_create'));

        $response->assertOk();
        $response->assertViewIs('admin.committee');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroy
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete('errors');
        $committee = Committee::factory()->create();
        //todo get proper relations for admin_user
      //  dump($this->admin_user->with('membership'));
      //  dump([$this->admin_user->id, $committee->user_id]);

        $response = $this->actingAs($committee->user_id)
            ->delete(route('committee_destroy'), ['id' => $committee->id]);

        //dump($response, 'DUUUMP');
        // $queries = \DB::getQueryLog();
        //   dump($queries);

        $this->assertModelMissing($committee);
        $response->assertRedirect(route('committees_list'));
    }

    /**
     * @test
     * @group destroy
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteeController::class,
            'destroy',
            \App\Http\Requests\Committees\DestroyCommitteeRequest::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $committee = Committee::factory()->create();

        $response = $this->actingAs($this->admin_user)->get(route('committee_edit', $committee->slug));

        $response->assertOk();
        $response->assertViewIs('admin.committee');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $committees = Committee::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('committees_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listcommittees');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group showok
     */
    public function show_returns_an_ok_response()
    {
        $committee = Committee::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_committee_show', ['any_committee' => $committee->slug]));

        $response->assertOk();
        $response->assertViewIs('admin.show_committee');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $committee = Committee::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/committee/create', [
            'committee' => $committee->toArray()
        ]);

        $this->assertEquals(Session::get('success'), 'You have created a new committee, '.$committee->name);
    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteeController::class,
            'store',
            \App\Http\Requests\Committees\StoreCommitteeRequest::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {

        //todo why errors
        $this->markTestIncomplete('errors');

        $committee = Committee::factory()->create();

        echo "\n committee id: " . $committee->id ."\n";
        echo "committee name: " . $committee->name ."\n";

        $data = Committee::find($committee->id);

        $data['committee'] = [
            "user_id" => 6,
            "name" => "bla bla " . $data->name,
            "description" => 'Update to description ' . $data->description,
            "email" => $data->email,
            "live" => $data->live
            ];

        $response = $this->actingAs($this->admin_user)
            ->post('admin/committee/'. $data->slug .'/edit', [
            'any_committee' => $data
        ]);

        //$response->assertRedirect(route('admin_committee_show', $data->slug));
        $response->assertRedirect('http://p118.local/admin/committee/'.$data->slug.'/edit');
    }

    /**
     * @test
     *  @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteeController::class,
            'update',
            \App\Http\Requests\Committees\UpdateCommitteeRequest::class
        );
    }
}
