<?php

namespace Tests\Unit\Http\Requests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Feature\StoreFeatureRequest
 */
class StoreFeatureRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Feature\StoreFeatureRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Feature\StoreFeatureRequest();
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
            'image' => 'file|nullable',
            'feature.title' => 'required|unique:features,title|max:255',
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
