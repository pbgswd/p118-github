<?php

namespace Tests\Feature;

use Session;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class UserTest extends TestCase
{
    /**
     * Insert users into users table
     *
     * @return void
     */
    //    use RefreshDatabase; // deletes all data
    public function testBasicTest()
    {

        $response = $this->get('/');
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("Laravel");
        }

        $response = $this->get('/register');

                if ($response->assertStatus(Response::HTTP_OK)) {
                    $response->assertSeeText("Register");
                }

        echo "\n public register new user page \n";

        $users = factory(User::class, 1)->make();

        foreach ($users as $user)
        {

            echo "attempting to insert ". $user['name'] . "\n";

            $response = $this->post(
                '/register',
                [
                    'user'=>[
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'password' => $user['password'],
                        'password-confirm' => $user['password'],
                    ],
                    '_token' => Session::token(),
                ]
            );
            echo  $user['name'] . " has been posted. \n";
        }
    }
}
