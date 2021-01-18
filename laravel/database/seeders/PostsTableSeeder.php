<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = \App\Models\User::pluck('id')->toArray();
        $topicIds = \App\Models\Topic::pluck('id')->toArray();
        $pageIds = \App\Models\Page::pluck('id')->toArray();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 2; $i++) {
            $title = $faker->text(20);
            $slug = strtolower($title);
            $date = date('Y-m-d H:i:s');
            $userIdKey = array_rand($userIds, 1);
            $pageIdsKey = array_rand($pageIds, 1);

            $topicIdKey = array_rand($topicIds, 1);

            DB::table('posts')->insert([
                'user_id' => $userIds[$userIdKey],
                'title' => $title,
                'slug' => $slug,
                'description' => $faker->text(30),
                'content' => $faker->text(1200),
                'image' => null,
                'access_level' => 'public',
                'live' => 1,
                'sort_order' => 1000 + (10 * $i),
                'in_menu' => 0,
                'allow_comments' => 0,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $postId = DB::getPdo()->lastInsertId();

            // constraint violation
            DB::table('post_topic')->insert([
                'topic_id' => $topicIds[$topicIdKey],
                'post_id' => $postId,
            ]);

            DB::table('page_post')->insert([
                'page_id' => $pageIds[$pageIdsKey],
                'post_id' => $postId,
            ]);

            // insert a bunch of rows of Posts with relationships
            // to topics, pages, as well as topics and pages together
        }
    }
}
