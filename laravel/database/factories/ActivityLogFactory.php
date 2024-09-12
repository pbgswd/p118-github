<?php

namespace Database\Factories;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'activity' => 'Activity description '.$this->faker->paragraph(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'model' => 'Model '.$this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
