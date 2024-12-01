<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message_categories', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->references('id')->on('messages')->index();
            $table->string('type');
            $table->string('name');
            $table->timestamps();
        });

       Schema::table('messages', function (Blueprint $table) {
           $table->dropColumn('section');
           $table->dropColumn('category');
       });

       Schema::table('users', function (Blueprint $table) {
          //todo set default is_banned=0
           $table->tinyInteger('is_banned')->default(0)->index()->change();
       });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_categories');

        Schema::table('messages', function (Blueprint $table) {
            $table->string('section')->after('source_url')->nullable();
            $table->string('category')->after('section')->nullable();
        });
    }
};
