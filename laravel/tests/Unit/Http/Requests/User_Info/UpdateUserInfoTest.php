<?php

namespace Tests\Unit\Http\Requests\User_Info;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\User_Info\UpdateUserInfo
 */
class UpdateUserInfoTest extends TestCase
{
    /** @var \App\Http\Requests\User_Info\UpdateUserInfo */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\User_Info\UpdateUserInfo();
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
            'user_info.share_email' => 'boolean',
            'user_info.share_phone' => 'boolean',
            'user_info.image' => 'string|nullable',
            'user_info.about' => 'string|max:2000|nullable',
        ], $actual);
    }

    // test cases...
}
