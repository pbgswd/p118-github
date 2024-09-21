<?php

namespace Tests\Unit\Http\Requests\Organization;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Organization\DestroyOrganizationRequest
 */
class DestroyOrganizationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Organization\DestroyOrganizationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Organization\DestroyOrganizationRequest;
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
