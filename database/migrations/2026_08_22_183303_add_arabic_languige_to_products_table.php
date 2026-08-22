<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicLanguigeToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bedcovers', function (Blueprint $table) {
            $table->string('ar_dimensions')->nullable()->after('dimensions');
            $table->string('ar_weight')->nullable()->after('weight');
            $table->string('ar_kind')->nullable()->after('kind');
            $table->string('ar_contains')->nullable()->after('contains');
            $table->string('ar_sewingType')->nullable()->after('sewingType');
            $table->string('ar_haveEster')->nullable()->after('haveEster');
            $table->string('ar_kindOfEster')->nullable()->after('kindOfEster');
            $table->string('ar_washable')->nullable()->after('washable');
            $table->string('ar_description')->nullable()->after('description');
        });
        Schema::table('fabrics', function (Blueprint $table) {
            $table->string('ar_dimensions')->nullable()->after('dimensions');
            $table->string('ar_weight')->nullable()->after('weight');
            $table->string('ar_kind')->nullable()->after('kind');
            $table->string('ar_washable')->nullable()->after('washable');
            $table->string('ar_description')->nullable()->after('description');
        });
        Schema::table('pillows', function (Blueprint $table) {
            $table->string('ar_dimensions')->nullable()->after('dimensions');
            $table->string('ar_weight')->nullable()->after('weight');
            $table->string('ar_kind')->nullable()->after('kind');
            $table->string('ar_description')->nullable()->after('description');
        });
        Schema::table('prayermats', function (Blueprint $table) {
            $table->string('ar_dimensions')->nullable()->after('dimensions');
            $table->string('ar_weight')->nullable()->after('weight');
            $table->string('ar_kind')->nullable()->after('kind');
            $table->string('ar_contains')->nullable()->after('contains');
            $table->string('ar_sewingType')->nullable()->after('sewingType');
            $table->string('ar_haveEster')->nullable()->after('haveEster');
            $table->string('ar_kindOfEster')->nullable()->after('kindOfEster');
            $table->string('ar_washable')->nullable()->after('washable');
            $table->string('ar_description')->nullable()->after('description');
        });
        Schema::table('tablecloths', function (Blueprint $table) {
            $table->string('ar_dimensions')->nullable()->after('dimensions');
            $table->string('ar_weight')->nullable()->after('weight');
            $table->string('ar_kind')->nullable()->after('kind');
            $table->string('ar_contains')->nullable()->after('contains');
            $table->string('ar_sewingType')->nullable()->after('sewingType');
            $table->string('ar_haveEster')->nullable()->after('haveEster');
            $table->string('ar_kindOfEster')->nullable()->after('haveEster');
            $table->string('ar_washable')->nullable()->after('washable');
            $table->string('ar_description')->nullable()->after('description');
            $table->string('ar_uses')->nullable()->after('uses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bedcovers', function (Blueprint $table) {
            $table->dropColumn('ar_dimensions');
            $table->dropColumn('ar_weight');
            $table->dropColumn('ar_kind');
            $table->dropColumn('ar_contains');
            $table->dropColumn('ar_sewingType');
            $table->dropColumn('ar_haveEster');
            $table->dropColumn('ar_kindOfEster');
            $table->dropColumn('ar_description');
            $table->dropColumn('ar_washable');
        });
        Schema::table('fabrics', function (Blueprint $table) {
            $table->dropColumn('ar_dimensions');
            $table->dropColumn('ar_weight');
            $table->dropColumn('ar_kind');
            $table->dropColumn('ar_washable');
            $table->dropColumn('ar_description');
        });
        Schema::table('pillows', function (Blueprint $table) {
            $table->dropColumn('ar_dimensions');
            $table->dropColumn('ar_weight');
            $table->dropColumn('ar_kind');
            $table->dropColumn('ar_description');
        });
        Schema::table('prayermats', function (Blueprint $table) {
            $table->dropColumn('ar_dimensions');
            $table->dropColumn('ar_weight');
            $table->dropColumn('ar_kind');
            $table->dropColumn('ar_contains');
            $table->dropColumn('ar_sewingType');
            $table->dropColumn('ar_haveEster');
            $table->dropColumn('ar_kindOfEster');
            $table->dropColumn('ar_washable');
            $table->dropColumn('ar_description');
        });
        Schema::table('tablecloths', function (Blueprint $table) {
            $table->dropColumn('ar_dimensions');
            $table->dropColumn('ar_weight');
            $table->dropColumn('ar_kind');
            $table->dropColumn('ar_contains');
            $table->dropColumn('ar_sewingType');
            $table->dropColumn('ar_haveEster');
            $table->dropColumn('ar_kindOfEster');
            $table->dropColumn('ar_washable');
            $table->dropColumn('ar_description');
            $table->dropColumn('ar_uses');
        });
    }
}
