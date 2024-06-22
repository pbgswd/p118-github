<?php

namespace Tests\Unit\Http\Requests\Venues;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Venues\DestroyVenueRequest
 */
class DestroyVenueRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Venues\DestroyVenueRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Venues\DestroyVenueRequest();
    }

    /**
     * @test
     */
    public function authorize(): void
    {

        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules(): void
    {

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'id' => 'required',
        ], $actual);
    }

    // test cases...
}
