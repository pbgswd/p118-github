<?php

namespace Tests\Unit\Http\Requests\Topic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Topic\DestroyTopicRequest
 */
class DestroyTopicRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Topic\DestroyTopicRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Topic\DestroyTopicRequest();
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
            'ids' => 'required',
        ], $actual);
    }

    // test cases...
}
