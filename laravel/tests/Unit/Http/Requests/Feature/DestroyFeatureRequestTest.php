<?php

namespace Tests\Unit\Http\Requests\Feature;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Feature\DestroyFeatureRequest
 */
class DestroyFeatureRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Feature\DestroyFeatureRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Feature\DestroyFeatureRequest();
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
            'id' => 'required',
        ], $actual);
    }

    // test cases...
}
