<?php

namespace Tests\Unit\Http\Requests\Topic;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Topic\UpdateTopicRequest
 */
class UpdateTopicRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Topic\UpdateTopicRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Topic\UpdateTopicRequest();
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
            'topic.access_level' => 'required|string|max:255',
            'topic.sort_order' => 'required|numeric',
            'topic.live' => 'boolean',
            'topic.front_page' => 'boolean',
            'topic.landing_page' => 'boolean',
        ], $actual);
    }

    // test cases...
}
