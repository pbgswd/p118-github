<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function testBasicTest()
    {
        echo "\n Begin ".basename(__FILE__)."\n";

        $response = $this->get('/');

        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('since 1904');
            echo "\n since 1904 seen \n";
        }

        echo "\n Login a user \n";

        $response = $this->call('POST', '/logout',
            [
                '_token' => csrf_token(),
            ]
        );

        $users = [
            [
                'email' => 'superwebdeveloper@gmail.com',
                'password' => 'honda750',
                'role' => 'super-admin',
            ],
            [
                'email' => 'pbgswd@gmail.com',
                'password' => 'pbgswdpbgswd',
                'role' => 'writer',
            ],
            [
                'email' => 'humyum@hotmail.com',
                'password' => 'a1humyum',
                'role' => 'office',
            ],
        ];

        foreach ($users as $u) {
            Session::start();
            $response = $this->get('/login');

            if ($response->assertStatus(Response::HTTP_OK)) {
                $response->assertSeeText('Login');
                echo "\n Login page \n";
            }

            echo "\n Attempting to log in ".$u['email']."\n";

            $response = $this->call('POST', '/login',
                [
                   'email' => $u['email'],
                   'password' => $u['password'],
                   '_token' => csrf_token(),
                ]
            );

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
                if ($response->assertSeeText('Hi '.$user->name)) {
                    echo "\n logged in as ".$user->name."\n";
                }
                if ($response->assertDontSeeText('monkey')) {
                    echo "\n I dont see monkey \n";
                }
            }

            if ($u->role == 'super-admin') {
                //test
            }
            if ($u->role == 'writer') {
                //test
            }
            if ($u->role == 'office') {
                //test
            }
            if ($u->role == 'member') {
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

        echo "\n End ".basename(__FILE__)."\n";
    }
}
