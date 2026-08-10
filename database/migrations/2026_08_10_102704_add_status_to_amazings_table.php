<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAmazingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amazings', function (Blueprint $table) {
            $table->boolean('is_passed')->default(false)->after('active');
            $table->boolean('is_applied')->default(false)->after('is_passed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amazings', function (Blueprint $table) {
            $table->dropColumn(['is_passed','is_applied']);
        });
    }
}
