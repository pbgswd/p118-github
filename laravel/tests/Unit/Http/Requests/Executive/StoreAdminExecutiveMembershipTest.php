<?php

namespace Tests\Unit\Http\Requests\Executive;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Executive\StoreAdminExecutive
 */
class StoreAdminExecutiveMembershipTest extends TestCase
{
    /** @var \App\Http\Requests\Executive\StoreAdminExecutive */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Executive\StoreAdminExecutive();
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
            'executive.executive_id' => 'required',
            'executive.start_date' => 'date',
            'executive.end_date' => 'date',
        ], $actual);
    }

    // test cases...
}
