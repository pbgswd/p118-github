<?php

namespace Tests\Unit\Http\Requests\Policies;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Policies\AdminUpdatePolicy
 */
class AdminUpdatePolicyTest extends TestCase
{
    /** @var \App\Http\Requests\Policies\AdminUpdatePolicy */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Policies\AdminUpdatePolicy();
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
            'policy.title' => 'required|max:255',
            'policy.date' => 'required|date',
            'policy.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
