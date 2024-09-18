<?php

namespace Tests\Unit\Http\Requests\Bylaws;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Bylaws\UpdateBylawRequest
 */
class UpdateBylawRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Bylaws\UpdateBylawRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Bylaws\UpdateBylawRequest;
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
            'bylaw.title' => 'required|max:255',
            'bylaw.description' => 'string',
            'bylaw.access_level' => 'required|string|max:255',
            'bylaw.date' => 'date',
            'bylaw.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
