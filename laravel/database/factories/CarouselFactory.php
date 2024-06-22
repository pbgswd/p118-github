<?php

namespace Database\Factories;

use App\Models\Carousel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarouselFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carousel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $alignment = ['left', 'center', 'right'];
        shuffle($alignment);

        return [
            'user_id' => \App\Models\User::factory(),
            'caption' => 'Caption '.$this->faker->words(2, true),
            'caption2' => 'Caption 2 '.$this->faker->sentence,
            'align' => $alignment[0],
            'text_color' => $this->faker->safeHexColor,
            'text_outline_color' => $this->faker->hexColor,
            'live' => 1,
            'order' => 2,
            'image_2000' => '2000.jpg',
            'file_2000' => '2000'.$this->faker->md5.'.jpg',
            'image_1400' => '1400.jpg',
            'file_1400' => '1400'.$this->faker->md5.'.jpg',
            'image_800' => '800.jpg',
            'file_800' => '800'.$this->faker->md5.'.jpg',
            'image_600' => '600.jpg',
            'file_600' => '600'.$this->faker->md5.'.jpg',
        ];
    }
}
