<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class PublicUserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPublicAccess()
    {
        $this->assertTrue(true);

        $response = $this->get('/');
        $response->assertOk();
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('since 1904');
        }
    }

    public function testHistory()
    {
        $response = $this->get('/page/history');
        $response->assertSeeText('On September 13, 1903');
    }

    public function testExecutive()
    {
        $response = $this->get('/executive');
        $response->assertSeeText('President');
    }

    public function testLinks()
    {
        $response = $this->get('/page/links');
        $response->assertSeeText('Union Links');

    }

    public function testOrganizations()
    {
        $response = $this->get('/organizations');
        $response->assertSeeText('Where we work');

        $response = $this->get('/organization/vancouver-symphony-orchestra');
        $response->assertSeeText('Vancouver Symphony Orchestra');

    }

    public function testVenues()
    {
        $response = $this->get('/venues');
        $response->assertSeeText('Venues');

        $response = $this->get('/venue/arts-club-theatre-granville-island-stage');
        $response->assertSeeText('Arts Club Theatre Granville Island Stage');

    }

    public function testAgreements()
    {
        $response = $this->get('/agreements');
        $response->assertSeeText('Collective Agreements');

        $response = $this->get('/agreement/9');
        $response->assertSeeText('Spectra Venue Management');
    }

    public function testHireUs() {
        $response = $this->get('/hire-us');
        $response->assertSeeText('Why hire IATSE Local 118');
    }

    public function testPublicToPrivate()
    {
        $response = $this->get('/');
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('since 1904');
        }
    }


    public function testBylaws()
    {
        $response = $this->get('/bylaws');
        $response->assertSeeText('1 Bylaw Document');

        $response = $this->get('/bylaw/1');
        echo "\n Response Status: " . $response->status() . "\n";
        $response->assertSeeText('Constitution and By-Laws October 23th, 2019');
    }

    public function testBylawDownload()
    {
        $response = $this->get('/bylaws/download/398');

        $header = $response->headers->get('content-disposition');

        $this->assertEquals($header, 'inline; filename="Constitution and By-Laws October 23, 2019.pdf"');

        /**
        $response->assertContains('attachment', (string)$response);
        $this->assertTrue(preg_match('/(error|notice)/i', $response) === false);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        **/

    }
}
