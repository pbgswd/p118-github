<?php

namespace Tests\Feature;

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Session;
use Tests\TestCase;

class TopicTest extends TestCase
{
    /**
     * Insert topics into topics table.
     *
     * @return void
     */
    //    use RefreshDatabase; // deletes all data
    public function testBasicTest()
    {
//todo this is an old test, it can be thrown out

/*        $response = $this->get('/admin/topic/');

        if ($response->assertStatus(Response::HTTP_OK)) {
            $response->assertSeeText("Topics");
        }*/

        $topics = Topic::factory()->count(20)->make();

        foreach ($topics as $topic) {

            $response = $this->actingAs($this->admin_user)
                ->post(
                    env('APP_URL') .'/admin/topic/create',
                    [
                        'topic' => $topic
                    ]
            );

            $response->assertRedirect(route(env('APP_URL') .'/admin/topic/'. Str::slug($topic->name) . "/edit"));

        }

        /*        $response = $this->get(route('topics_list'));

                if ($response->assertStatus(Response::HTTP_OK)) {
                    $response->assertSeeText("List Topics");
                    echo "\n Admin List topics page \n";
                }*/
    }
}
