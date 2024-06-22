<?php

namespace Tests\Unit\Http\Requests\Committees;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Committees\DestroyCommitteeRequest
 */
class DestroyCommitteeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Committees\DestroyCommitteeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Committees\DestroyCommitteeRequest();
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
            'id' => 'required',
        ], $actual);
    }

    // test cases...
}
