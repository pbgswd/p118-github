<?php

namespace Tests\Unit\Http\Requests\CommitteePost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteePost\UpdateCommitteePostRequest
 */
class UpdateCommitteePostRequestTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteePost\UpdateCommitteePostRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteePost\UpdateCommitteePostRequest();
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
       $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' cannot be tested without context');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'post.access_level' => 'required|string|max:255',
            'post.title' => 'required|max:255|unique:committee_posts,title,slug',
            'post.content' => 'required',
            'post.sticky' => 'boolean',
            'post.allow_comments' => 'boolean',
            'post.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
