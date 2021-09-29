<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class PublicContactFormTest extends TestCase
{
    /**
     *
     */
    public function testPublicContactPage()
    {
        echo "\n Begin method " . basename(__METHOD__). "\n";
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('America/Vancouver'));
        $date = $date->format('F j, Y H:i:s');

        $response = $this->get('/contact');
        $response->assertSeeText('Contact IATSE Local 118');

        echo "\n Attempting to send a message"."\n";

        //todo mocking & stubs
        $recaptcha = "6Ldv4sQaAAAAAJApVGt3T9XUyZcNFDrKLS_Umu1A";

        $response = $this->call('POST', '/contact',
            [
                'name' => 'test Sender '.$date,
                'email' => 'unittesting@test.com',
                'mail_subject' => 'test contact page submission '.$date,
                'mail_body' => $date.' lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                        lorem ipsum lorem ipsum lorem ipsum ',
                '_token' => csrf_token(),
            ]
        );

        if ($response->assertStatus(Response::HTTP_FOUND)) {
            if ($response->assertSeeText('Redirecting to http')) {
                echo "\n message sent \n";
            }
        }
        echo "\n End method ".basename(__METHOD__). "\n";
    }
}
