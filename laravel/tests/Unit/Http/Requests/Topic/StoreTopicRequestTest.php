<?php

namespace Tests\Unit\Http\Requests\Topic;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Topic\StoreTopicRequest
 */
class StoreTopicRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Topic\StoreTopicRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Topic\StoreTopicRequest();
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
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.access_level' => 'required|string|max:255',
            'topic.sort_order' => 'required|numeric',
            'topic.live' => 'boolean',
            'topic.description' => 'string|max:255',
            'topic.front_page' => 'boolean',
            'topic.landing_page' => 'boolean',
        ], $actual);
    }

    // test cases...
}
