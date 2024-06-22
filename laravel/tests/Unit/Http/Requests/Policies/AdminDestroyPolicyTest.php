<?php

namespace Tests\Unit\Http\Requests\Policies;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Policies\AdminDestroyPolicy
 */
class AdminDestroyPolicyTest extends TestCase
{
    /** @var \App\Http\Requests\Policies\AdminDestroyPolicy */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Policies\AdminDestroyPolicy();
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
            'id' => 'required',
        ], $actual);
    }

    // test cases...
}
