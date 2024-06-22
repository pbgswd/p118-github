<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'mail_subject' => $this->faker->text(5),
            'mail_body' => $this->faker->text(200),
            //'g-recaptcha-response'
        ];
    }
}
