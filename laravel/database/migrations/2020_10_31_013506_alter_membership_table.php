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
        Schema::table('memberships', function (Blueprint $table) {
            $table->string('membership_type')
                ->default('Member')
                ->after('user_id');
            $table->date('membership_date')->nullable()->change();
            $table->date('membership_expires')->nullable()->change();
            $table->unsignedInteger('seniority_number')->nullable()->change();
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('membership_type');

            $table->date('membership_date')->change();
            $table->date('membership_expires')->change();
            $table->unsignedInteger('seniority_number')->change();
            $table->string('status')->change();
        });
    }
};
