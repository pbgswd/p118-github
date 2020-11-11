  <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMembershipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('membership_type');

            $table->date('membership_date')->change();
            $table->date('membership_expires')->change();
            $table->unsignedInteger('seniority_number')->change();
            $table->string('status')->change();
        });
    }
}
