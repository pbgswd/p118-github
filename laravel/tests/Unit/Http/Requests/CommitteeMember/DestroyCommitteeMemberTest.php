<?php

namespace Tests\Unit\Http\Requests\CommitteeMember;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteeMember\DestroyCommitteeMember
 */
class DestroyCommitteeMemberTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteeMember\DestroyCommitteeMember */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteeMember\DestroyCommitteeMember();
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
            'user_id' => 'required|exists:committee_user',
        ], $actual);
    }

    // test cases...
}
