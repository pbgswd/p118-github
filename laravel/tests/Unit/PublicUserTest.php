<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PublicUserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testPublicAccess()
    {
        echo "\n Begin " . basename(__FILE__) . "\n";
        $this->assertTrue(true);

        $response = $this->get('/');
        $response->assertOk();
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("since 1904");
        }

        $response = $this->get('/page/history');
        $response->assertSeeText('History of Local 118');

        $response = $this->get('/bylaws');
        $response->assertSeeText('Local 118 Constitution and By-Laws');
        $response = $this->get('/bylaws/1');
        $response->assertSeeText('Constitution and By-Laws October 23');

        //todo download
        $response->getContent('/bylaws/download/398');

        $header = $response->headers->get('content-disposition');

        $this->assertEquals($header, "attachment; filename=Permittee Application.pdf");

        //$response->assertContains('attachment', (string)$response);
        //$this->assertTrue(preg_match('/(error|notice)/i', $response) === false);
       // $response->assertHeader('content-type', 'text/html; charset=UTF-8');

        $response = $this->get('/executive');
        $response->assertSeeText('President');

        $response = $this->get('/page/links');
        $response->assertSeeText('general links of interest to anyone in Theatre');

        $response = $this->get('/organizations');
        $response->assertSeeText('Where we work');
        $response = $this->get('/organization/vso');
        $response->assertSeeText('The Vancouver Symphony Orchestra');

        $response = $this->get('/venues');
        $response->assertSeeText('Venues');
        $response = $this->get('/venue/arts-club-granville-island');
        $response->assertSeeText('Arts Club Granville Island');

        $response = $this->get('/agreements');
        $response->assertSeeText('Collective Agreements');
        $response = $this->get('/agreement/38');
        $response->assertSeeText('Master Casual Agreement 2019');

        $response = $this->get('/hire-us');
        $response->assertSeeText('Why hire IATSE Local 118');
    }

    public function testPublicContactPage()
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('America/Vancouver'));
        $date = $date->format('F j, Y H:i:s');

        $response = $this->get('/contact');
        $response->assertSeeText('Contact IATSE Local 118');

        echo "\n Attempting to send a message" . "\n";

        $response = $this->call('POST', '/contact',
                [
                    'name' => 'test Sender ' . $date,
                    'email' => 'unittesting@test.com',
                    'mail_subject' => 'test contact page submission ' . $date,
                    'mail_body' => $date . " lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                        lorem ipsum lorem ipsum lorem ipsum ",
                    '_token' => csrf_token(),
                ]
            );

        if ($response->assertStatus(Response::HTTP_FOUND)) {
            if($response->assertSeeText("Redirecting to http")) {
                echo "\n message sent " . "\n";
            }
        }

        echo "\n End " . basename( __FILE__ ) . "\n";
    }

    public function testPublicToPrivate()
    {
        echo "\n begin testPublicToPrivate method in " . basename( __FILE__ ) . "\n";
        $response = $this->get('/');
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("since 1904");
        }
    }
}
