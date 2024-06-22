<?php

namespace Tests\Unit\Http\Requests\Committees;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Committees\StoreCommitteeRequest
 */
class StoreCommitteeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Committees\StoreCommitteeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Committees\StoreCommitteeRequest();
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
            'committee.name' => 'required|unique:committees,name|max:255',
            'committee.description' => 'required',
            'committee.email' => 'string|max:255',
            'committee.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
