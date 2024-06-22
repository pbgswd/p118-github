<?php

namespace Tests\Unit\Http\Requests\Employment;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Employment\UpdateEmploymentRequest
 */
class UpdateEmploymentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Employment\UpdateEmploymentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Employment\UpdateEmploymentRequest();
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
            'employment.title' => 'required|max:255',
            'employment.description' => 'string|nullable',
            'employment.url' => 'url|nullable',
            'employment.live' => 'boolean',
            'employment.deadline' => 'date',
        ], $actual);
    }

    // test cases...
}
