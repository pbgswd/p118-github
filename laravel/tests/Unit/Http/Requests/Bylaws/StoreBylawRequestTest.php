<?php

namespace Tests\Unit\Http\Requests\Bylaws;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Bylaws\StoreBylawRequest
 */
class StoreBylawRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Bylaws\StoreBylawRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Bylaws\StoreBylawRequest();
    }

    /**
     * @test
     */
    public function authorize()
    {
       //

        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules()
    {
        //

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'bylaw.title' => 'required|max:255',
            'bylaw.description' => 'string',
            'bylaw.access_level' => 'required|string|max:255',
            'bylaw.date' => 'date',
            'bylaw.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
