<?php

namespace Tests\Unit\Http\Requests\CommitteePostComment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteePostComment\UpdateCommitteePostCommentRequest
 */
class UpdateCommitteePostCommentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteePostComment\UpdateCommitteePostCommentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteePostComment\UpdateCommitteePostCommentRequest();
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
            'comment.content' => 'required',
        ], $actual);
    }

    // test cases...
}
