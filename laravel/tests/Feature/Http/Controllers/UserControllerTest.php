<?php

namespace Tests\Feature\Http\Controllers;


use App\Models\Address;
use Illuminate\Http\Response;
use Tests\TestCase;


/**
 * @see \App\Http\Controllers\UserController
 */
class UserControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('members'));
        $response->assertOk();
        $response->assertViewIs('listusers');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group show
     */
    public function not_authenticated_index_returns_a_response()
    {
        $response = $this->get(route('members'));
        $response->assertStatus(Response::HTTP_FOUND); //302
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('member_edit', [$this->user]));

        $response->assertOk();
        $response->assertViewIs('member_edit');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function edit_address_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('member_address_edit', [$this->user]));

        $response->assertOk();
        $response->assertViewIs('member_address_edit');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function edit_emergency_contact_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('edit_emergency_contact', [$this->user]));

        $response->assertOk();
        $response->assertViewIs('member_emergency_edit');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function edit_password_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('member_password_edit', [$this->user]));

        $response->assertOk();
        $response->assertViewIs('member_password_edit');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group show
     */
    public function show_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('member', [$this->user]));

        $response->assertOk();
        $response->assertViewIs('member');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group submit
     */
    public function update_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('member_edit', [$this->user]));

        $response->assertViewIs('member_edit');

        $response = $this->actingAs($this->user)->post(
            route('member_edit', $this->user),
            [
            'user' => ['email' => $this->faker->email(),
                    'phone_number' =>
                    [
                        'phone_number' => $this->faker->phoneNumber()
                    ],
            ],
            'user_info' => [
                $this->user->user_info->toArray()
            ],
        ]);

       $response->assertRedirect(route('member_edit', $this->user));
    }

    /**
     * @test
     * @group submit
     */
    public function original_update_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->post(env('APP_URL').'/member/' . $this->user->id . '/edit', [
            'user' => ['email' => $this->faker->email(),
                'phone_number' =>
                    [
                        'phone_number' => $this->faker->phoneNumber()
                    ],
            ],
            'user_info' => [
                $this->user->user_info->toArray()
            ],
        ]);

        $response->assertRedirect(route('member_edit', $this->user->id));
    }

    /**
     * @test
     * @group form-request
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update',
            \App\Http\Requests\Member\UpdateMember::class
        );
    }

    /**
     * @test
     * @group address
     */
    public function update_address_returns_an_ok_response()
    {
        $address = Address::factory()->make();

        $response = $this->actingAs($this->user)->post(
            env('APP_URL') . '/member/' . $this->user->id . '/address/edit',
            $address->toArray()
        );
//$response->ddSession()['errors'];
        $response->assertSessionHas('success');
        $response->assertRedirect(route('member_address_edit', $this->user->id));
    }

    /**
     * @test
     * @group form-request
     */
    public function update_address_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update_address',
            \App\Http\Requests\User\UpdateMemberAddress::class
        );
    }

    /**
     * @test
     * @group emergency
     */
    public function update_emergency_contact_returns_an_ok_response()
    {
        $data = [
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_relationship' => 'spouse',
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'message' => $this->faker->text(20)
        ];

        $response = $this->actingAs($this->user)->post(
            env('APP_URL') . '/member/' . $this->user->id . '/emergency_contact/edit',
            $data
        );

        $response->assertRedirect(route('edit_emergency_contact', $this->user->id));
    }

    /**
     * @test
     * @group password
     *
     */
    public function update_emergency_contact_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update_emergency_contact',
            \App\Http\Requests\Member\UpdateMemberEmergencyContact::class
        );
    }

    /**
     * @test
     * @group password
     */
    public function update_password_returns_an_ok_response()
    {
        $password = $this->faker->password();
        $data = [
            'password' => $password,
            'password_confirmation' => $password
        ];

        // this is the original provided post method, that I need to modify
/****
        $response = $this->actingAs($this->user)->post('member/{user}/password', [
            // TODO: send request data
        ]);
***/
        $response = $this->actingAs($this->user)->post(env('APP_URL') . '/member/' . $this->user->id . '/password',
            $data
        );
        $response->assertRedirect(route('member_password_edit', $this->user->id));
    }

    /**
     * @test
     * @group password
     */
    public function update_password_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update_password',
            \App\Http\Requests\InviteUser\ProcessUserRequest::class
        );
    }


}
