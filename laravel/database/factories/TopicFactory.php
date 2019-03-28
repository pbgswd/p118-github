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

    $title = $faker->text(20);
    $slug = strtolower($title);

    return [
        'topic.name' => $title,
        'topic.slug' => $slug,
        'topic.description' => $faker->text(50),
        'topic.image' => strtolower($faker->text(5)).'.jpg',
        'topic.scope' => 'public',
        'topic.live' => 'yes',
        'topic.sort_order' => 1000,
        'topic.in_menu' => 'yes',
        'topic.allow_comments' => 'yes',
        ];
});
