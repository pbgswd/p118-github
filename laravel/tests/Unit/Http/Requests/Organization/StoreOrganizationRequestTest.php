<?php

namespace Tests\Unit\Http\Requests\Organization;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Organization\StoreOrganizationRequest
 */
class StoreOrganizationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Organization\StoreOrganizationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Organization\StoreOrganizationRequest();
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
            'organization.name' => 'required|unique:organizations,name|max:255',
            'organization.description' => 'required|string',
            'organization.url' => 'url|nullable',
            'organization.live' => 'boolean',
            'image' => 'file|nullable',
        ], $actual);
    }

    // test cases...
}
