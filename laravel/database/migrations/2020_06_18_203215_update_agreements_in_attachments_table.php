<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('attachments')
            ->where('subfolder', 'agreements')
            ->update(['access_level' => 'public']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
