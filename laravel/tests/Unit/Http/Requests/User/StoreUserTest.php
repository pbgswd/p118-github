<?php

namespace Tests\Unit\Http\Requests\User;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\User\StoreUser
 */
class StoreUserTest extends TestCase
{
    /** @var \App\Http\Requests\User\StoreUser */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\User\StoreUser();
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
            'user.name' => 'required|max:255',
            'user.email' => 'required|unique:users,email|max:255',
            'user_phone.phone_number' => 'max:20',
            'user_phone.label' => 'string|nullable',
            'user_phone.primary' => 'boolean',
            'user_info.share_email' => 'boolean',
            'user_info.share_phone' => 'boolean',
            'user_info.file_name' => 'string|nullable',
            'user_info.image' => 'string|nullable',
            'user_info.about' => 'string|nullable|max:2000',
            'user_address.unit' => 'max:255|nullable',
            'user_address.street' => 'string|required|max:255',
            'user_address.city' => 'string|required|max:255',
            'user_address.province' => 'string|required|max:255',
            'user_address.postal_code' => 'string|required|max:255',
            'user_address.country' => 'string|required|max:255',
            'user_role' => 'required',
        ], $actual);
    }

    // test cases...
}
