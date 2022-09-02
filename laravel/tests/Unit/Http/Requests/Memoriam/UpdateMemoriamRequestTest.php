<?php

namespace Tests\Unit\Http\Requests\Memoriam;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Memoriam\UpdateMemoriamRequest
 */
class UpdateMemoriamRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Memoriam\UpdateMemoriamRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Memoriam\UpdateMemoriamRequest();
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
        $this->markTestSkipped(__FUNCTION__ . ' in ' . __FILE__ . ' cant be tested without context. Use Feature test');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'memoriam.title' => 'required|max:255|unique:memoriams,title,'.$this->route('any_memoriam')->slug.',slug',
            'memoriam.content' => 'string|nullable',
            'memoriam.live' => 'boolean',
            'image' => 'file|nullable',
            'memoriam.date' => 'date',
        ], $actual);
    }

    // test cases...
}
