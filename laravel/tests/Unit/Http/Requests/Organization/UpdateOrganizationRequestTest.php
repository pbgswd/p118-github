<?php

namespace Tests\Unit\Http\Requests\Organization;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Organization\UpdateOrganizationRequest
 */
class UpdateOrganizationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Organization\UpdateOrganizationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Organization\UpdateOrganizationRequest;
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
        $this->markTestSkipped(__FUNCTION__.' in '.__FILE__.' cant be tested without context. Use Feature test');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'organization.name' => 'required|max:255|unique:organizations,name,'.$this->route('any_organization')->slug.',slug',
            'organization.description' => 'required|string',
            'organization.url' => 'url|nullable',
            'organization.live' => 'boolean',
            'image' => 'file|nullable',
        ], $actual);
    }

    // test cases...
}
