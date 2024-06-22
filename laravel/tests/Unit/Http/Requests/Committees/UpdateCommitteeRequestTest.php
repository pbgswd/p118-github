<?php

namespace Tests\Unit\Http\Requests\Committees;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Committees\UpdateCommitteeRequest
 */
class UpdateCommitteeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Committees\UpdateCommitteeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Committees\UpdateCommitteeRequest();
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
        $this->markTestSkipped(__FUNCTION__.' in '.__FILE__.' cannot be tested without context. Use Feature test');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'committee.name' => 'required|max:255|unique:committees,name,'.$this->route('any_committee')->slug.',slug',
            'committee.description' => 'required',
            'committee.email' => 'string|max:255',
            'committee.image' => 'file|nullable',
            'committee.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
