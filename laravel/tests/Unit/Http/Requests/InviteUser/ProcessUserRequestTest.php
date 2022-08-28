<?php

namespace Tests\Unit\Http\Requests\InviteUser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\InviteUser\ProcessUserRequest
 */
class ProcessUserRequestTest extends TestCase
{
    /** @var \App\Http\Requests\InviteUser\ProcessUserRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\InviteUser\ProcessUserRequest();
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
            'password' => 'required|min:6|dumbpwd|confirmed',
        ], $actual);
    }

    // test cases...
}
