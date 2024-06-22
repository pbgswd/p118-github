<?php

namespace Tests\Unit\Http\Requests\Bylaws;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Bylaws\DestroyBylawRequest
 */
class DestroyBylawRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Bylaws\DestroyBylawRequest */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Bylaws\DestroyBylawRequest();
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
        //

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'id' => 'required',
        ], $actual);
    }

    // test cases...
}
