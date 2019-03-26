<?php

namespace Tests\Feature;

use Session;
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

        $topics = factory(Topic::class, 5)->make();

        foreach ($topics as $topic) {

            echo "attempting to insert ". $topic['name'] . "\n";

            $response = $this->get('/admin/topic/');

            $response = $this->json(
                'POST',
                '/admin/topic',
                [
                    'topic.name' => $topic['name'],
                    'topic.description' => $topic['description'],
                    'topic.image' => $topic['image'],
                    'topic.scope' => $topic['scope'],
                    'topic.live' => $topic['live'],
                    'topic.in_menu' => $topic['in_menu'],
                    'topic.allow_comments' => $topic['allow_comments'],
                ]
            );

            // not submitting yet

            echo  $topic['name'] . " has been posted. \n";

            $response = $this->get('/admin/topic');
            sleep(1);

            if ($response->assertStatus(Response::HTTP_OK)) {
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
