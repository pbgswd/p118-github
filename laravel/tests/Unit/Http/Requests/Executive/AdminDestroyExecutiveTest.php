<?php

namespace Tests\Unit\Http\Requests\Executive;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Executive\AdminDestroyExecutive
 */
class AdminDestroyExecutiveTest extends TestCase
{
    /** @var \App\Http\Requests\Executive\AdminDestroyExecutive */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Executive\AdminDestroyExecutive();
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
            'id' => 'required|exists:executives',
        ], $actual);
    }

    // test cases...
}
