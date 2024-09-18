<?php

namespace Tests\Unit\Http\Requests\CommitteeMember;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteeMember\SearchCommitteeMember
 */
class SearchCommitteeMemberTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteeMember\SearchCommitteeMember */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteeMember\SearchCommitteeMember;
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
            'search' => 'string|required|max:64|min:2',
        ], $actual);
    }

    // test cases...
}
