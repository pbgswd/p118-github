<?php

namespace Tests\Unit\Http\Requests\CommitteePost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\CommitteePost\DestroyCommitteePostRequest
 */
class DestroyCommitteePostRequestTest extends TestCase
{
    /** @var \App\Http\Requests\CommitteePost\DestroyCommitteePostRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\CommitteePost\DestroyCommitteePostRequest();
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
            'id' => 'required|exists:committee_posts',
        ], $actual);
    }

    // test cases...
}
