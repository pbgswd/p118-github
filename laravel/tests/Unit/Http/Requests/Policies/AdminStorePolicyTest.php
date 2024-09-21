<?php

namespace Tests\Unit\Http\Requests\Policies;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Policies\AdminStorePolicy
 */
class AdminStorePolicyTest extends TestCase
{
    /** @var \App\Http\Requests\Policies\AdminStorePolicy */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Policies\AdminStorePolicy;
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
            'policy.title' => 'required|max:255',
            'policy.date' => 'date',
            'policy.live' => 'boolean',
        ], $actual);
    }

    // test cases...
}
