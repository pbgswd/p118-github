<?php

namespace Tests\Unit\Http\Requests\Page;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Page\UpdatePageRequest
 */
class UpdatePageRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Page\UpdatePageRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Page\UpdatePageRequest;
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

        $this->markTestSkipped(__FUNCTION__.' in '.__FILE__.' cant be tested without context. Use Feature test');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'page.title' => 'required|max:255|unique:pages,title,'.$this->route('any_page')->slug.',slug',
            'page.content' => 'required',
            'page.access_level' => 'required|string|max:255',
            'page.live' => 'boolean',
            'page.front_page' => 'boolean',
            'page.landing_page' => 'boolean',
        ], $actual);
    }

    // test cases...
}
