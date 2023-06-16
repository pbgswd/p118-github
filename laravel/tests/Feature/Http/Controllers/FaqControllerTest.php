<?php

namespace Tests\Feature\Http\Controllers;
use App\Models\Faq;
use Tests\TestCase;

class FaqControllerTest extends TestCase
{
    /**
     * @test
     * @group listok
     */
    public function list_returns_an_ok_response()
    {
        $faqs = Faq::factory()->times(3)->create();

        $response = $this->get(route('faqs_list_public'));

        $response->assertOk();
        $response->assertViewIs('faqs');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group showok
     */
    public function show_returns_an_ok_response()
    {
        $faq = Faq::factory()->create();

        $response = $this->get(route('faq_show', $faq->id));

        $response->assertOk();
        $response->assertViewIs('faq_view');
        $response->assertViewHas('data');
    }
}
