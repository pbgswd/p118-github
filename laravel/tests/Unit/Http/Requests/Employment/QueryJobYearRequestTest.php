<?php

namespace Tests\Unit\Http\Requests\Employment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Employment\QueryJobYearRequest
 */
class QueryJobYearRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Employment\QueryJobYearRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Employment\QueryJobYearRequest();
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
            'deadline' => 'integer|required|digits:4',
        ], $actual);
    }

    // test cases...
}
