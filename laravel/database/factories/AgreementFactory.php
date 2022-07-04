<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Agreement;

class AgreementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agreement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => 'Agreement ' . $this->faker->name(),
            'description' => 'Agreement description text ' . $this->faker->paragraph(),
            'access_level' => 'members',
            'live' => 1,
            'from' => Carbon::now()->subDays(20),
            'until' => Carbon::now()->addYears(3),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}
