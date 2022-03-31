<?php

namespace Tests\Unit;

use App\Models\InviteUser;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    /**
     * @return array
     */
    public function userProvider()
    {
        return [
            'example user with member privileges' =>
            [
                'name' => 'testname 1',
                'email' => 'abcd@xyz.com',
                'password' => 'averygoodPassword100',
                'membership_type' => 'Member',
                'role' => 'member'
            ],
            'example user with super-admin privileges' =>
            [
                'name' => 'testname 2',
                'email' => 'superwebdeveloper@gmail.com',
                'password' => 'honda750',
                'membership_type' => 'Member',
                'role' => 'super-admin'
            ],
            /*
            'example user with writer privileges' =>
            [
                'name' => 'testname 3',
                'email' => 'pbgswd@gmail.com',
                'password' => 'pbgswdpbgswd',
                'membership_type' => 'Member',
                'role' => 'writer',
            ],
                        'example user with writer privileges' =>
            [
                'name' => 'testname 4',
                'email' => 'committeepbgswd@gmail.com',
                'password' => 'pbgswdpbgswd',
                'membership_type' => 'Member',
                'role' => 'committee',
            ],
            'example user with office privileges' =>
            [
                'name' => 'testname 5',
                'email' => 'humyum@hotmail.com',
                'password' => 'a1humyum',
                'membership_type' => 'Office',
                'role' => 'office',
            ],
            */
        ];
    }

    /**
     * @dataProvider userProvider
     */
    public function testInviteUserWasInvited($name, $email, $password, $membership_type, $role)
    {
/**
 * InviteUser
 * InviteUserController
 * store method
 */

        $response = $this->call('POST', '/admin/invite-new-user',
            [
                'invite[name]' => $name,
                'invite[email]' => $email,
                'invite[membership_type]' => $membership_type,
                'invite[role]' => $role,
                '_token' => csrf_token()
            ]
        );

        $this->assertDatabaseHas('invite_users', ['email' => $email]);

    }


    /**
     * @dataProvider userProvider
     */
    public function testSeesTheWebsiteIndex()
    {

        $response = $this->call('POST', '/logout',
            [
                '_token' => csrf_token(),
            ]
        );



        Session::start();
        $response = $this->get('/login');

        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('Login');
            echo "\n Login page \n";
        }
        foreach ($users as $u) {

            echo "\n Attempting to log in " . $u['email'] ." \n";

            $response = $this->call('POST', '/login',
                [
                   'email' => $u['email'],
                   'password' => $u['password'],
                   '_token' => csrf_token(),
                ]
            );

            echo "\n Response Status: " . $response->status() . "\n";

            if ($response->assertStatus(Response::HTTP_FOUND)) {
                if ($response->assertSeeText('Redirecting to http')) {
                    echo "\n Redirecting to http ... \n";
                }
            } else {
                die(" \n stopping after login attempt \n");
            }

            $user = Auth::user()->load('phone_number',
                'user_info',
                'address',
                'allExecutiveRoles',
                'committee_memberships',
                'membership'
            );

            $response = $this->get('/site');

            if ($response->assertStatus(Response::HTTP_OK)) {
                if ($response->assertSeeText('Hi '. $user->name)
                    && $response->assertSeeText('Logout')
                    && $response->assertSeeText('Call Steward')) {
                    echo "\n logged in as " . $user->name . "\n";
                }
            }

            if ($u['role'] == 'super-admin') {
                //test
            }

            if ($u['role'] == 'writer') {
                //test
            }

            if ($u['role'] == 'office') {
                //test
            }

            if ($u['role'] == 'member') {
                //test
            }

            // user own profile
            //user update own profile

            // user update some other profile attempt

            //user admin see link

            // user admin see dashboard

            // user admin see menu based on roles

            // user admin manage users

            //user admin manage models

            //todo member hits routes

            //todo as above, higher roles and privileges, also admin section, user, and other models

            $response = $this->call('POST', '/logout',
                [
                    '_token' => csrf_token(),
                ]
            );
        }
        echo "\n End method " . basename(__METHOD__). "\n";
    }
}
