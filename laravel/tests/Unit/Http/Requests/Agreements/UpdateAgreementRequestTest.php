<?php

namespace Tests\Unit\Http\Requests\Agreements;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Agreements\UpdateAgreementRequest
 */
class UpdateAgreementRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Agreements\UpdateAgreementRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Agreements\UpdateAgreementRequest();
    }

    /**
     * @test
     */
    public function authorize(): void
    {
        //

        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules(): void
    {
        //

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'agreement.client' => 'array',
            'agreement.title' => 'required|max:255',
            'agreement.from' => 'required|date',
            'agreement.until' => 'required|date',
            'agreement.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
