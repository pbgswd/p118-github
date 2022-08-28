<?php

namespace Tests\Unit\Http\Requests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Feature\UpdateFeatureRequest
 */
class UpdateFeatureRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Feature\UpdateFeatureRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Feature\UpdateFeatureRequest();
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
        $this->markTestIncomplete(__FUNCTION__ . ' in ' . __FILE__ . ' has issues');

        $actual = $this->subject->rules();

        $this->assertValidationRules([
            'feature.title' =>  'required|max:255|unique:pages,title,'.$this->route('any_feature')->slug.',slug',
            'delete_image' => 'boolean',
            'image' => 'file|nullable',
            'feature.url' => 'string|nullable|max:255',
            'feature.content' => 'required',
            'feature.image' => 'string|nullable',
            'feature.file_name' => 'string|nullable',
            'feature.date' => 'date',
            'feature.live' => 'boolean',
            'feature.front_page' => 'boolean',
            'feature.landing_page' => 'boolean',
        ], $actual);
    }

    // test cases...
}
