<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = $this->faker->company().' organization';
        $file_name = ''; // strtolower($this->faker->text(5));

        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'url' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'file_name' => '', //$file_name .'.jpg',
            'image' => '', //bcrypt($file_name).'.jpg',
            'access_level' => 'members',
            'live' => 1,
        ];
    }
}
