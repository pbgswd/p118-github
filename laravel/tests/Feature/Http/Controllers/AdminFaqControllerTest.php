<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Faq;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminFaqControllerTest extends TestCase
{
    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin_faq_create'));

        $response->assertOk();
        $response->assertViewIs('admin.faq_topic_create');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group
     */
    public function destroy_returns_an_ok_response(): void
    {
        $faq = \App\Models\Faq::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_faq_destroy', ['id' => $faq->id]));

        $this->assertModelMissing($faq);
        $response->assertRedirect(route('admin_faqs_list'));
    }

    /**
     * @test
     *
     * @group
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminFaqController::class,
            'destroy',
            \App\Http\Requests\Faq\DestroyFaqRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response(): void
    {
        $faq = \App\Models\Faq::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_faq_edit', $faq->id));

        $response->assertOk();
        $response->assertViewIs('admin.faq');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $faqs = \App\Models\Faq::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('admin_faqs_list'));

        $response->assertOk();
        $response->assertViewIs('admin.faqs_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $faq = \App\Models\Faq::factory()->make();

        $response = $this->actingAs($this->admin_user)->post('admin/faq/create', [
            'faq' => $faq->toArray(),
        ]);

        $this->assertEquals(Session::get('success'), 'faq posting saved');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminFaqController::class,
            'store',
            \App\Http\Requests\Faq\StoreFaqRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        $faq = \App\Models\Faq::factory()->create();

        $data = Faq::first();

        $data['description'] = 'Description edit '.$data->description;

        $response = $this->actingAs($this->admin_user)
            ->post('admin/faq/'.$data->id.'/edit', [
                'faq' => $data->toArray(),
            ]);

        $response->assertRedirect(route('admin_faq_edit', ['any_faq' => $data->id]));
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminFaqController::class,
            'update',
            \App\Http\Requests\Faq\UpdateFaqRequest::class
        );
    }
}
