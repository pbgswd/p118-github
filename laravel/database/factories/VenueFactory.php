<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Venue;
use Faker\Generator as Faker;

$factory->define(Venue::class, function (Faker $faker) {

    $name = $faker->company . " hall";
    $slug = strtolower($name);

    return [
        'name' => $name,
        'slug' => $slug,
        'description' => $faker->text(50),
        'image' => strtolower($faker->text(5)).'.jpg',
        'scope' => 'public',
        'live' => 'yes',
        'sort_order' => '1000',
        'in_menu' => 'yes',
        'allow_comments' => 'yes',
    ];
});
