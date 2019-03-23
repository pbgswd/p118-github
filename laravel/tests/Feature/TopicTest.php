<?php

namespace Tests\Feature;

use Session;
use App\User;
use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class TopicTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    //    use RefreshDatabase; // deletes all data
    public function testBasicTest()
    {

        $response = $this->get('/admin/topic/create');

        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("Topics");
            echo "\n Admin create topics page \n";
        }

        $topics = factory(Topic::class, 2)->make();



        foreach ($topics as $topic) {
            echo "Topic Name: " . $topic['name'] . "\n";
        }

        exit();

        $response = $this->get('/admin/topics');

        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("List Topics");
            echo "\n Admin List topics page \n";
        }
    }
}
