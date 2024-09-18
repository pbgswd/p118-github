<?php

namespace Tests\Unit\Http\Requests\Employment;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Employment\QueryJobYearRequest
 */
class QueryJobYearRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Employment\QueryJobYearRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Employment\QueryJobYearRequest;
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
            'deadline' => 'integer|required|digits:4',
        ], $actual);
    }

    // test cases...
}
