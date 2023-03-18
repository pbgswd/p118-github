<?php

namespace Database\Factories;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attachment;

class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $this->admin_user = User::factory()
            ->has(Membership::factory(),'membership')
            ->create();
        $this->admin_user->assignRole(['member', 'super-admin', 'committee']);

        $word = $this->faker->word();

        return [
            'user_id' => $this->admin_user->id,
            'description' => "attachment_name_" . $word,
            'file_name' => $word . ".jpg",
            'file' => $word . "_" . $this->faker->md5() . ".jpg",
            'access_level' => 'public',
            'subfolder' => 'public',
        ];
    }
}
