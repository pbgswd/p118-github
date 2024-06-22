<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class QrcodeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
