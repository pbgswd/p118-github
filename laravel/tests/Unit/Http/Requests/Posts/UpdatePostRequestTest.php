<?php

namespace Tests\Unit\Http\Requests\Posts;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Posts\UpdatePostRequest
 */
class UpdatePostRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Posts\UpdatePostRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Posts\UpdatePostRequest();
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
        $this->markTestSkipped(__FUNCTION__.' in '.__FILE__.' cant be tested without context. Use Feature test');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'post.title' => 'required|max:255|unique:posts,title,'.$this->route('any_post')->slug.',slug',
            'post.content' => 'required',
            'post.access_level' => 'required|string|max:255',
            'post.live' => 'boolean',
            'post.front_page' => 'boolean',
            'post.landing_page' => 'boolean',
        ], $actual);
    }

    // test cases...
}
