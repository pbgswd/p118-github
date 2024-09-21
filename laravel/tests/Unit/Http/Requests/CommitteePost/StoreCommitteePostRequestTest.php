<?php

namespace Tests\Unit\Http\Requests\CommitteePost;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteePost\StoreCommitteePostRequest
 */
class StoreCommitteePostRequestTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteePost\StoreCommitteePostRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
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
            'post.access_level' => 'required|string|max:255',
            'post.title' => 'required|unique:committee_posts,title|max:255',
            'post.content' => 'required',
            'post.sticky' => 'boolean',
            'post.allow_comments' => 'boolean',
            'post.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
