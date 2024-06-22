<?php

namespace Tests\Unit\Http\Requests\Agreements;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Agreements\DestroyAgreementRequest
 */
class DestroyAgreementRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Agreements\DestroyAgreementRequest */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Agreements\DestroyAgreementRequest();
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
            'id' => 'required',
        ], $actual);
    }
}
