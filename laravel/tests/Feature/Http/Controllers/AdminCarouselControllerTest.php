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
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->delete(route('carousel.destroy', [$carousel]));

        $response->assertOk();
        $this->assertModelMissing($carousel);


    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->get(route('carousel.edit', [$carousel]));

        $response->assertOk();


    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('carousel.index'));

        $response->assertOk();
        $response->assertViewIs('admin.carousel_list');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->get(route('carousel.show', [$carousel]));

        $response->assertOk();


    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post(route('carousel.store'), [
            // TODO: send request data
        ]);

        $response->assertOk();


    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->put(route('carousel.update', [$carousel]), [
            // TODO: send request data
        ]);

        $response->assertOk();


    }


}
