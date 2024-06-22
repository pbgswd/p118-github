<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Carousel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminCarouselController
 */
class AdminCarouselControllerTest extends TestCase
{
    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin_carousel_list'));

        $response->assertOk();
        $response->assertViewIs('admin.carousel_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    /* public function destroy_returns_an_ok_response()
     {
         $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' has no code');

         $carousel = \App\Models\Carousel::factory()->create();

         $response = $this->delete(route('carousel.destroy', [$carousel]));

         $response->assertOk();
         $this->assertModelMissing($carousel);
     }*/

    /**
     * @test
     *
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_carousel_edit', [$carousel]));

        $response->assertOk();
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin_carousel_list'));

        $response->assertOk();
        $response->assertViewIs('admin.carousel_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group showok
     */
    /* public function show_returns_an_ok_response()
     {
         $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' has no code');

         $carousel = \App\Models\Carousel::factory()->create();

         $response = $this->actingAs($this->admin_user)->get(route('carousel.show', [$carousel]));

         $response->assertOk();
     }*/

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $carousel = \App\Models\Carousel::factory()->make();
        $response = $this->actingAs($this->admin_user)->post(route('admin_carousel_store'), [
            'carousel' => $carousel->toArray(),
        ]);

        $response->assertOk();
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $carousel = \App\Models\Carousel::factory()->create();

        $data = Carousel::first();

        $data['caption2'] = 'Update to caption2'.$data->caption2;

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_carousel_update', [
                'any_carousel' => $data->toArray(),
            ]));

        $response->assertOk();
    }
}
