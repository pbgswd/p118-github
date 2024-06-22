<?php

namespace Tests\Unit\Http\Requests\InviteUser;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\InviteUser\DestroyInviteUserRequest
 */
class DestroyInviteUserRequestTest extends TestCase
{
    /** @var \App\Http\Requests\InviteUser\DestroyInviteUserRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\InviteUser\DestroyInviteUserRequest();
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
            'id' => 'required|exists:invite_users',
        ], $actual);
    }

    // test cases...
}
