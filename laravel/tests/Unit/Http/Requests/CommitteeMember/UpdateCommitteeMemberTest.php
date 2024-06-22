<?php

namespace Tests\Unit\Http\Requests\CommitteeMember;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteeMember\UpdateCommitteeMember
 */
class UpdateCommitteeMemberTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteeMember\UpdateCommitteeMember */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteeMember\UpdateCommitteeMember();
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
            'role' => 'required|string',
        ], $actual);
    }

    // test cases...
}
