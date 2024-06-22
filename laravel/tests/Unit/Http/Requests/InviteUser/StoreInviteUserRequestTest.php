<?php

namespace Tests\Unit\Http\Requests\InviteUser;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\InviteUser\StoreInviteUserRequest
 */
class StoreInviteUserRequestTest extends TestCase
{
    /** @var \App\Http\Requests\InviteUser\StoreInviteUserRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\InviteUser\StoreInviteUserRequest();
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
            'invite.name' => 'required|string|min:2|max:255',
            'invite.email' => 'required|email|min:6|max:255',
            'invite.membership_type' => 'required|string',
            'invite.message' => 'max:1024',
            'invite.role' => 'required|string',
        ], $actual);
    }

    // test cases...
}
