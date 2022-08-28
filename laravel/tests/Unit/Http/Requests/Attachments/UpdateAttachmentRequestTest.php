<?php

namespace Tests\Unit\Http\Requests\Attachments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\Attachments\UpdateAttachmentRequest
 */
class UpdateAttachmentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Attachments\UpdateAttachmentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Attachments\UpdateAttachmentRequest();
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
            'attachment.access_level' => 'string|required',
            'attachment.description' => 'string|max:256|nullable',
        ], $actual);
    }

    // test cases...
}
