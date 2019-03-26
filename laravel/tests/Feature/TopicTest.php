<?php

namespace Tests\Feature;

use Session;
//use App\User;
use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class TopicTest extends TestCase
{
    /**
     * Insert topics into topics table
     *
     * @return void
     */
    //    use RefreshDatabase; // deletes all data
    public function testBasicTest()
    {

        $response = $this->get('/admin/topic/');

        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("Topics");
            echo "\n Admin create topics page \n";
        }

        $topics = factory(Topic::class, 2)->make();


        foreach ($topics as $topic) {

            echo "attempting to insert ". $topic['name'] . "\n";

            $response = $this->get('/admin/topic/');

            $response = $this->json(
                'POST',
                '/admin/topic',
                [
                    'name' => $topic['name'],
                    'description' => $topic['description'],
                    'image' => $topic['image'],
                    'scope' => $topic['scope'],
                    'live' => $topic['live'],
                    'in_menu' => $topic['in_menu'],
                    'allow_comments' => $topic['allow_comments'],
                ]
            );

            $response = $this->get('/admin/topic');
            sleep(1);
            if ($response->assertStatus(Response::HTTP_OK)) {
//                $response->assertSeeText($user['username']);
                echo $topic['name'] . " has been stored in db. \n";
            }

        }

        $response = $this->get('/admin/topics');

        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("List Topics");
            echo "\n Admin List topics page \n";
        }
    }
}
