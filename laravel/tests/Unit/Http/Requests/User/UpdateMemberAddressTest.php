<?php

namespace Tests\Unit\Http\Requests\User;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\User\UpdateMemberAddress
 */
class UpdateMemberAddressTest extends TestCase
{
    /** @var \App\Http\Requests\User\UpdateMemberAddress */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\User\UpdateMemberAddress;
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
            'unit' => 'max:255|nullable',
            'street' => 'max:255|required',
            'city' => 'max:255|required',
            'province' => 'max:255|required',
            'postal_code' => 'max:255|required',
        ], $actual);
    }

    // test cases...
}
