<?php

namespace Tests\Unit\Http\Requests\Memoriam;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Memoriam\DestroyMemoriamRequest
 */
class DestroyMemoriamRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Memoriam\DestroyMemoriamRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Memoriam\DestroyMemoriamRequest();
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
