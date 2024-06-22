<?php

namespace Tests\Unit\Http\Requests\CommitteePostComment;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteePostComment\StoreCommitteePostCommentRequest
 */
class StoreCommitteePostCommentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteePostComment\StoreCommitteePostCommentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteePostComment\StoreCommitteePostCommentRequest();
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
            'comment.content' => 'required',
        ], $actual);
    }

    // test cases...
}
