<?php

namespace Tests\Unit\Http\Requests\Attachments;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Attachments\StoreAttachmentRequest
 */
class StoreAttachmentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Attachments\StoreAttachmentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Attachments\StoreAttachmentRequest;
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
            'attachment.access_level' => 'string|required',
            'attachment.description' => 'string|max:256|nullable',
            'images' => 'required',
        ], $actual);
    }

    // test cases...
}
