<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class UserSeeder extends Seeder
{
    use HasRoles;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {

            $date = date('Y-m-d H:i:s');

            $userData = [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => $date,
                'password' => bcrypt('secret'),
                'created_at' => $date,
                'updated_at' => $date,
                'is_banned' => null,
            ];

            $user = new User($userData);
            $user->save();

            DB::table('phone_numbers')->insert([
                'user_id' => $user->id,
                'phone_number' => $faker->phoneNumber(),
                'label' => 'mobile',
                'primary' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            DB::table('users_info')->insert([
                'user_id' => $user->id,
                'share_email' => $faker->boolean(),
                'share_phone' => $faker->boolean(),
                'image' => '',
                'about' => $faker->text(1000),
            ]);

            // assign all members the member role

            $user->assignRole('member');

            DB::table('memberships')->insert([
                'user_id' => $user->id,
                'membership_type' => 'member',
                'membership_date' => null,
                'membership_expires' => null,
                'seniority_number' => null,
                'status' => null,
                'admin_notes' => $faker->text(600),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
