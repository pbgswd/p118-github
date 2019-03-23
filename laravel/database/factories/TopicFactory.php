<?php

use App\Models\Topic;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Topic::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'safe_name' => $faker->name,
        'description' => $faker->text(10),
        'content' => $faker->text(30),
        'image' => 'image.jpg',
        'scope' => 'public',
        'live' => 'yes',
        'sort_order' => 1000,
        'in_menu' => 'yes',
        'topic_type' => 'entry',
        'allow_comments' => 'yes',
        ];
});
