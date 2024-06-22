<?php

namespace Tests\Unit\Http\Requests\Meetings;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Meetings\QueryMeetingYearRequest
 */
class QueryMeetingYearRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Meetings\QueryMeetingYearRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Meetings\QueryMeetingYearRequest();
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
            'year' => 'integer|required|digits:4',
        ], $actual);
    }

    // test cases...
}
