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
            $response->assertSeeText('Our Affiliations');
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
    }

    public function testOrganizationPage()
    {
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

    public function testHireUs()
    {
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
        $response->assertSeeText('Constitution');

        $response = $this->get('/bylaw/50');
        echo "\n Response Status: ".$response->status()."\n";
        $response->assertSeeText('Constitution and By-Laws of IATSE Local 118 - December 21st, 2021');
    }

    public function testBylawsPage()
    {
        $response = $this->get('/bylaw/50');
        echo "\n Response Status: ".$response->status()."\n";
        $response->assertSeeText('Constitution and By-Laws of IATSE Local 118 - December 21st, 2021');
    }

    public function testBylawSinglePageDownload()
    {
        $response = $this->get('/bylaws/download/1356');

        $header = $response->headers->get('content-disposition');

        $this->assertEquals($header, 'inline; filename="Constitution and By-Laws December 21, 2021.pdf"');

        /**
        $response->assertContains('attachment', (string)$response);
        $this->assertTrue(preg_match('/(error|notice)/i', $response) === false);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        **/
    }
}
