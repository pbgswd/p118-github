<?php

namespace Tests\Unit\Http\Requests\Venues;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Venues\UpdateVenueRequest
 */
class UpdateVenueRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Venues\UpdateVenueRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Venues\UpdateVenueRequest();
    }

    /**
     * @test
     */
    public function authorize()
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules()
    {
        $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' cant be tested without context. Use Feature test');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'venue.description' => 'required|string',
            'venue.url' => 'url|nullable',
            'venue.live' => 'boolean',
            'venue.admin_notes' => 'string|nullable',
            'venue.image' => 'string|nullable',
            'venue.file_name' => 'string|nullable',
        ], $actual);
    }

    // test cases...
}
