<?php

namespace Tests\Unit\Http\Requests\Meetings;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Meetings\DestroyMeetingRequest
 */
class DestroyMeetingRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Meetings\DestroyMeetingRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Meetings\DestroyMeetingRequest();
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
