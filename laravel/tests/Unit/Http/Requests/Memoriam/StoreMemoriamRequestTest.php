<?php

namespace Tests\Unit\Http\Requests\Memoriam;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Memoriam\StoreMemoriamRequest
 */
class StoreMemoriamRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Memoriam\StoreMemoriamRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Memoriam\StoreMemoriamRequest();
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
            'memoriam.title' => 'required|unique:memoriams,title|max:255',
            'memoriam.content' => 'string|nullable',
            'memoriam.live' => 'boolean',
            'image' => 'file|nullable',
            'memoriam.date' => 'date',
        ], $actual);
    }

    // test cases...
}
