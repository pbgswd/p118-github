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
        echo "\n Begin method " . basename(__METHOD__) . "\n";

        $this->assertTrue(true);

        $response = $this->get('/');
        $response->assertOk();
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('since 1904');
        }
        echo "\n End method ".basename(__METHOD__). "\n";
    }

    public function testHistory()
    {
        echo "\n Begin method " . basename(__METHOD__) . "\n";

        $response = $this->get('/page/history');
        $response->assertSeeText('On September 13, 1903');
        echo "\n End method ".basename(__METHOD__). "\n";
    }

    public function testExecutive()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";
        $response = $this->get('/executive');
        $response->assertSeeText('President');
        echo "\n End method ".basename(__METHOD__). "\n";
    }

    public function testLinks()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";
        $response = $this->get('/page/links');
        $response->assertSeeText('Union Links');
        echo "\n End method ".basename(__METHOD__). "\n";
    }

    public function testOrganizations()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";
        $response = $this->get('/organizations');
        $response->assertSeeText('Where we work');

        $response = $this->get('/organization/vancouver-symphony-orchestra');
        $response->assertSeeText('Vancouver Symphony Orchestra');
        echo "\n End method ".basename(__METHOD__). "\n";
    }

    public function testVenues()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";
        $response = $this->get('/venues');
        $response->assertSeeText('Venues');

        $response = $this->get('/venue/arts-club-theatre-granville-island-stage');
        $response->assertSeeText('Arts Club Theatre Granville Island Stage');
        echo "\n End method ".basename(__METHOD__). "\n";
    }

    public function testAgreements()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";
        $response = $this->get('/agreements');
        $response->assertSeeText('Collective Agreements');

        $response = $this->get('/agreement/9');
        $response->assertSeeText('Spectra Venue Management');
    }

    public function testHireUs() {
        echo "\n Begin method " . basename(__METHOD__). "\n";
        $response = $this->get('/hire-us');
        $response->assertSeeText('Why hire IATSE Local 118');
        echo "\n End method ".basename(__METHOD__). "\n";
    }

    public function testPublicToPrivate()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";

        echo "\n begin testPublicToPrivate method in " . basename(__FILE__) . "\n";
        $response = $this->get('/');
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('since 1904');
        }

        echo "\n End method " . basename(__METHOD__) . "\n";
    }


    public function testBylaws()
    {
        echo "\n Begin method " . basename(__METHOD__) . "\n";

        $response = $this->get('/bylaws');
        $response->assertSeeText('1 Bylaw Document');

        $response = $this->get('/bylaw/1');
        echo "\n Response Status: " . $response->status() . "\n";
        $response->assertSeeText('Constitution and By-Laws October 23th, 2019');

        echo "\n End method ".basename(__METHOD__). "\n";

    }

    public function testBylawDownload()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";

        $response = $this->get('/bylaws/download/398');

        $header = $response->headers->get('content-disposition');

        $this->assertEquals($header, 'inline; filename="Constitution and By-Laws October 23, 2019.pdf"');

        /**
        $response->assertContains('attachment', (string)$response);
        $this->assertTrue(preg_match('/(error|notice)/i', $response) === false);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        **/
        echo "\n End method ".basename(__METHOD__). "\n";
    }
}
