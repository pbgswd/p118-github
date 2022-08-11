<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminController
 */
class AdminControllerTest extends TestCase
{
   // use RefreshDatabase;

    /**
     * @test
     * @group blankok
     */
    public function blank_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('blank'));

        $response->assertOk();
        $response->assertViewIs('admin.admin-blank');
    }

    /**
     * @test
     * @group devok
     */
    public function developer_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('developer'));

        $response->assertOk();
        $response->assertViewIs('admin.developer_admin');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin'));

        $response->assertOk();
        $response->assertViewIs('admin.admin');
        $response->assertViewHas('data');

    }
}
