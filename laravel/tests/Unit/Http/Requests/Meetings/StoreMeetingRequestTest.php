<?php

namespace Tests\Unit\Http\Requests\Meetings;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Meetings\StoreMeetingRequest
 */
class StoreMeetingRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Meetings\StoreMeetingRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Meetings\StoreMeetingRequest();
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
            'meeting.title' => 'string|required|max:255',
            'meeting.description' => 'string|nullable',
        ], $actual);
    }

    // test cases...
}
