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

    $title = $faker->text(5);
    $slug = strtolower($title);

    return [
        'name' => $title,
        'slug' => $slug,
        'description' => $faker->text(10),
        'image' => strtolower($faker->text(5)).'.jpg',
        'scope' => 'public',
        'live' => 'yes',
        'sort_order' => 1000,
        'in_menu' => 'yes',
        'allow_comments' => 'yes',
        ];
});
