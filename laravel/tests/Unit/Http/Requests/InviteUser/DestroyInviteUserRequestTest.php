<?php

namespace Tests\Unit\Http\Requests\InviteUser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            'id' => 'required|exists:invite_users',
        ], $actual);
    }

    // test cases...
}
