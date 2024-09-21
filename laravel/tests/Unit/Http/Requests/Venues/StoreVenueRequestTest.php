<?php

namespace Tests\Unit\Http\Requests\Venues;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Venues\StoreVenueRequest
 */
class StoreVenueRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Venues\StoreVenueRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Venues\StoreVenueRequest;
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
            'venue.name' => 'required|unique:venues,name|max:255',
            'venue.description' => 'required|string',
            'venue.url' => 'url|nullable',
            'venue.live' => 'boolean',
            'venue.admin_notes' => 'string|nullable',
            'image' => 'file|nullable',
        ], $actual);
    }

    // test cases...
}
