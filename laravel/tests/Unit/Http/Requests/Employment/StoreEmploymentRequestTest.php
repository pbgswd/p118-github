<?php

namespace Tests\Unit\Http\Requests\Employment;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Employment\StoreEmploymentRequest
 */
class StoreEmploymentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Employment\StoreEmploymentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Employment\StoreEmploymentRequest();
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
