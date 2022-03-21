<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('membership_type');
            $table->timestamps();
        });

        $csv = [];
        $lines = file('storage/app/public/h5hsfMzfcgMZCnsHaB7U6LTflMm7Pl5PGC4HtRCz.txt', FILE_IGNORE_NEW_LINES);

        foreach ($lines as $key => $value) {
            $csv[$key] = str_getcsv($value);
        }

        $data = [];

        foreach ($csv as $k => $c) {
            $data[$k]['name'] = $c[0].' '.$c[1];
            $data[$k]['email'] = $c[2];
            $data[$k]['membership_type'] = $c[3];
        }

        foreach ($data as $d) {
            DB::table('import_users')->insert([
                'name' => $d['name'],
                'email' => $d['email'],
                'membership_type' => $d['membership_type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_users');
    }
}
