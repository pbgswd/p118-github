<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactController
 */
class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $contact = \App\Models\Contact::factory()->create();
        $pages = \App\Models\Page::factory()->times(3)->create();

        $response = $this->get(route('contact'));

        $response->assertOk();
        $response->assertViewIs('contact');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function submit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('contact', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('contact'));


    }

    /**
     * @test
     */
    public function submit_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactController::class,
            'submit',
            \App\Http\Requests\Contact\SubmitContact::class
        );
    }


}
