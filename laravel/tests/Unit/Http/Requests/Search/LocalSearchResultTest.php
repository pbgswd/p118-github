<?php

namespace Tests\Unit\Http\Requests\Search;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Search\LocalSearchResult
 */
class LocalSearchResultTest extends TestCase
{
    /** @var \App\Http\Requests\Search\LocalSearchResult */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Search\LocalSearchResult();
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
            'search' => 'string|required|max:64|min:2',
        ], $actual);
    }

    // test cases...
}
