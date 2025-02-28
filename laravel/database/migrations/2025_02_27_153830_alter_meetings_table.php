<?php

use App\Models\Meeting;
use App\Models\Options;
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
        Schema::table('meetings', function (Blueprint $table) {
            $table->string('meeting_type')->after('description')->nullable(); //meeting type

        });

        $meeting_types = Options::meeting_types();
        $meetings = Meeting::all();

        foreach ($meetings as $meeting) {

            if (strstr($meeting->title, 'Executive')) {
                $meeting->update(['meeting_type' => 'Executive']);
            }

            if (strstr($meeting->title, 'General')) {
                $meeting->update(['meeting_type' => 'General']);
            }

            if (strstr($meeting->title, 'Special')) {
                $meeting->update(['meeting_type' => 'Special']);
            }
        }

        $meetings = Meeting::all();
        foreach ($meetings as $meeting) {
            if (empty($meeting->meeting_type)) {
                $meeting->update(['meeting_type' => 'Other']);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('meeting_type');
        });
    }
};
