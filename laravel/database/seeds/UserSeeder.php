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

        $user_roles = array('writer', 'member', 'monkey', 'editor');
        $user_roles = array_combine($user_roles, $user_roles);

        for ($i = 24; $i < 2; $i++) {
            $date = date('Y-m-d H:i:s');

            echo "starting \n";

            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
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
                'about' => $faker->text(200),
            ]);

            DB::table('addresses')->insert([
                'user_id' => $userId,
                'unit' => '',
                'street' => $faker->address . " " . $faker->streetName,
                'city' => $faker->city,
                'province' => 'British Columbia',
                'postal_code' => $faker->postcode,
                'country' => 'Canada',
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $role = new Role(array_rand($user_roles, 1));
            $role->save();

            DB::table('memberships')->insert([
                'user_id' => $userId,
                'membership_date' => '2010-02-01',
                'membership_expires' => '2020-02-01',
                'seniority_number' => $i,
                'status' => 'current',
                'admin_notes' => $faker->text(200),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
