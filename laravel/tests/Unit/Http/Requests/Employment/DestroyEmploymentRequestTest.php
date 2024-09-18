<?php

namespace Tests\Unit\Http\Requests\Employment;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Employment\DestroyEmploymentRequest
 */
class DestroyEmploymentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Employment\DestroyEmploymentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Employment\DestroyEmploymentRequest;
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
            'id' => 'required|exists:employment',
        ], $actual);
    }

    // test cases...
}
