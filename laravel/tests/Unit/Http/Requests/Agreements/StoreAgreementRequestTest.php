<?php

namespace Tests\Unit\Http\Requests\Agreements;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Agreements\StoreAgreementRequest
 */
class StoreAgreementRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Agreements\StoreAgreementRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Agreements\StoreAgreementRequest();
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
            'agreement.client' => 'array',
            'agreement.title' => 'required|max:255',
            'agreement.from' => 'date',
            'agreement.until' => 'date',
            'agreement.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
