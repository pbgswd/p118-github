<?php

namespace Tests\Unit\Http\Requests\Posts;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Posts\DestroyPostRequest
 */
class DestroyPostRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Posts\DestroyPostRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Posts\DestroyPostRequest();
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
            'id' => 'required',
        ], $actual);
    }

    // test cases...
}
