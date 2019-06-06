<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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

        for ($i = 0; $i < 2; $i++) {

            $date = date('Y-m-d H:i:s');

            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $date,
                'password' => bcrypt('secret'),
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $userId =  DB::getPdo()->lastInsertId();

            DB::table('phone_numbers')->insert([
               'user_id' => $userId,
               'phone_number' => $faker->phoneNumber,
               'label' => 'mobile',
               'primary' => 1,
               'created_at' => $date,
               'updated_at' => $date,
            ]);

            DB::table('users_info')->insert([
                'user_id' => $userId,
                'share_email' => $faker->boolean,
                'share_phone' => $faker->boolean,
                'image' => '',
                'about' => $faker->text(1000),
            ]);

            DB::table('addresses')->insert([
                'user_id' => $userId,
                'unit' => $faker->numberBetween(1, 55),
                'street' => $faker->streetAddress,
                'city' => $faker->city,
                'province' => 'BC',
                'postal_code' => $faker->postcode,
                'country' => 'Canada',
                'created_at' => $date,
                'updated_at' => $date,
            ]);

           // $user = new User::find($userId);
           // $user->assignRole('member');

            DB::table('memberships')->insert([
                'user_id' => $userId,
                'membership_date' => '2010-02-01',
                'membership_expires' => '2020-02-01',
                'seniority_number' => $userId,
                'status' => 'current',
                'admin_notes' => $faker->text(600),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
