<?php

namespace Tests\Unit\Http\Requests\Contact;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\Contact\SubmitContact
 */
class SubmitContactTest extends TestCase
{
    /** @var \App\Http\Requests\Contact\SubmitContact */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Contact\SubmitContact();
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
            'email' => 'required|email|min:6|max:255',
            'name' => 'required|min:2|max:255',
            'mail_subject' => 'required|min:6|max:255',
            'mail_body' => 'required|min:6|max:2000',
            'g-recaptcha-response' => 'required',
        ], $actual);
    }

    // test cases...
}
