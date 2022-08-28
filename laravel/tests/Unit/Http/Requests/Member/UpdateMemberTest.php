<?php

namespace Tests\Unit\Http\Requests\Member;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Member\UpdateMember
 */
class UpdateMemberTest extends TestCase
{
    /** @var \App\Http\Requests\Member\UpdateMember */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Member\UpdateMember();
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
        $this->markTestIncomplete(__FUNCTION__ . ' in ' . __FILE__ . ' has issues');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'user_phone.label' => 'string|nullable',
            'user_phone.primary' => 'boolean',
            'user_info.share_email' => 'boolean',
            'user_info.share_phone' => 'boolean',
            'user_info.image' => 'string|nullable',
            'user_info.about' => 'string|nullable|max:2000',
        ], $actual);
    }

    // test cases...
}
