<?php

namespace Tests\Unit\Http\Requests\Page;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Page\StorePageRequest
 */
class StorePageRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Page\StorePageRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Page\StorePageRequest;
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
            'page.title' => 'required|unique:pages,title|max:255',
            'page.content' => 'required',
            'page.access_level' => 'required|string|max:255',
            'page.live' => 'boolean',
            'page.front_page' => 'boolean',
            'page.landing_page' => 'boolean',
        ], $actual);
    }

    // test cases...
}
