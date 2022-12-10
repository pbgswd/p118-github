<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminCarouselController
 */
class AdminCarouselControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('carousel.create'));

        $response->assertOk();
        $response->assertViewIs('admin.carousel');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' has no code');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->delete(route('carousel.destroy', [$carousel]));

        $response->assertOk();
        $this->assertModelMissing($carousel);


    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' has no code');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->get(route('carousel.edit', [$carousel]));

        $response->assertOk();
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('carousel.index'));

        $response->assertOk();
        $response->assertViewIs('admin.carousel_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group showok
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' has no code');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->actingAs($this->admin_user)->get(route('carousel.show', [$carousel]));

        $response->assertOk();
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
       $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' has no code');
        $carousel = \App\Models\Carousel::factory()->make();
        $response = $this->actingAs($this->admin_user)->post(route('carousel.store'), [
            'carousel' => $carousel->toArray()
        ]);

        $response->assertOk();
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' has no code');

        $carousel = \App\Models\Carousel::factory()->create();

        $data = Carousel::first();

        $data['description'] = 'Update to description' . $data->description;

        $response = $this->put(route('carousel.update', [$carousel]), [
            'carousel' => $data
        ]);

        $response->assertOk();
    }
}
