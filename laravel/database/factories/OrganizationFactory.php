<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organization;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company().' organization';
        $file_name = strtolower($this->faker->text(5));

        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $name,
            'slug' => strtolower($name),
            'url' => $this->faker->url(),
            'description' => $this->faker->text(50),
            'file_name' => $file_name .'.jpg',
            'image' => bcrypt($file_name).'.jpg',
            'access_level' => 'members',
            'live' => 1
        ];
    }
}
