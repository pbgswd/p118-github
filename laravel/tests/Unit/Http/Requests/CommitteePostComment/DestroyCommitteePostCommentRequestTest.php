<?php

namespace Tests\Unit\Http\Requests\CommitteePostComment;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteePostComment\DestroyCommitteePostCommentRequest
 */
class DestroyCommitteePostCommentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteePostComment\DestroyCommitteePostCommentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteePostComment\DestroyCommitteePostCommentRequest;
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
            'id' => 'required|exists:committee_post_comments',
        ], $actual);
    }

    // test cases...
}
