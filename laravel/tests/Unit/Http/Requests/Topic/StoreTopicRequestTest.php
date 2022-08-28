<?php

namespace Tests\Unit\Http\Requests\Topic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->markTestIncomplete(__FUNCTION__ . ' in ' . __FILE__ . ' has issues');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.access_level' => 'required|string|max:255',
            'topic.sort_order' => 'required|numeric',
            'topic.in_menu' => 'boolean',
            'topic.allow_comments' => 'boolean',
            'topic.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
