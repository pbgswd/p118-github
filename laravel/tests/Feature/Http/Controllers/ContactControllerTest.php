<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactController
 */
class ContactControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
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
       $this->markTestIncomplete( __FUNCTION__ .' has issues. -- needs g-recaptcha-response');
        $contact = \App\Models\Contact::factory()->make();
        $response = $this->post('contact', [
            $contact
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
