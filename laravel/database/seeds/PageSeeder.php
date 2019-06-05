<?php

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {

            $title = $faker->text(20);
            $slug  = strtolower($title);
            $date  = date('Y-m-d H:i:s');

            DB::table('pages')->insert([
                'user_id' => 1,
                'title' => $title,
                'slug' => $slug,
                'description' => $faker->text(30),
                'content' => $faker->text(200),
                'image' => null,
                'access_level' => 'members',
                'live' => 0,
                'sort_order' => 1000 + (10 * $i),
                'in_menu' => 0,
                'allow_comments' => 0,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}

