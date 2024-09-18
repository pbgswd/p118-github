<?php

namespace Tests\Unit\Http\Requests\Member;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Member\UpdateMemberEmergencyContact
 */
class UpdateMemberEmergencyContactTest extends TestCase
{
    /** @var \App\Http\Requests\Member\UpdateMemberEmergencyContact */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Member\UpdateMemberEmergencyContact;
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
            'emergency_contact_name' => 'max:255',
            'emergency_contact_relationship' => 'max:255',
            'emergency_contact_phone' => 'required|min:10',
            'message' => 'max:2000',
        ], $actual);
    }

    // test cases...
}
