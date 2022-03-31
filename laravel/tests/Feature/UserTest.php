<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Session;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Some work with users
     *
     * @return void
     */
    //    use RefreshDatabase; // deletes all data
    public function testBasicTest()
    {
        $response = $this->get('/');
        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText('Login');
        }

        $response = $this->get('/register');

        if ($response->assertStatus(Response::HTTP_NOT_FOUND)) {
            echo "\n public register new user page is blocked. \n";
        }

        /**
        $users = User::factory()->count(1)->make();
        print_r($users[0]->name);
        foreach ($users as $user) {
            echo 'attempting to insert '.$user['name']."\n";
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
            echo  $user['name']." has been posted. \n";
        }
        * **/
    }
}
