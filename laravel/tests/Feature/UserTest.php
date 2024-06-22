<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Some work with users
     */
    //    use RefreshDatabase; // deletes all data
    public function testBasicTest(): void
    {
        $response = $this->get('/');
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('Login');
        }

        $response = $this->get('/register');

        if ($response->assertStatus(Response::HTTP_NOT_FOUND)) {
            echo "\n public register new user page is blocked. \n";
        }
    }
}
