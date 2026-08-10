<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnglishFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bedcovers', function (Blueprint $table) {
            $table->string('e_dimensions')->nullable()->after('dimensions');
            $table->string('e_weight')->nullable()->after('weight');
            $table->string('e_kind')->nullable()->after('kind');
            $table->string('e_contains')->nullable()->after('contains');
            $table->string('e_sewingType')->nullable()->after('sewingType');
            $table->string('e_haveEster')->nullable()->after('haveEster');
            $table->string('e_kindOfEster')->nullable()->after('kindOfEster');
            $table->string('e_washable')->nullable()->after('washable');
            $table->string('e_description')->nullable()->after('description');
        });
        Schema::table('fabrics', function (Blueprint $table) {
            $table->string('e_dimensions')->nullable()->after('dimensions');
            $table->string('e_weight')->nullable()->after('weight');
            $table->string('e_kind')->nullable()->after('kind');
            $table->string('e_washable')->nullable()->after('washable');
            $table->string('e_description')->nullable()->after('description');
        });
        Schema::table('pillows', function (Blueprint $table) {
            $table->string('e_dimensions')->nullable()->after('dimensions');
            $table->string('e_weight')->nullable()->after('weight');
            $table->string('e_kind')->nullable()->after('kind');
            $table->string('e_description')->nullable()->after('description');
        });
        Schema::table('prayermats', function (Blueprint $table) {
            $table->string('e_dimensions')->nullable()->after('dimensions');
            $table->string('e_weight')->nullable()->after('weight');
            $table->string('e_kind')->nullable()->after('kind');
            $table->string('e_contains')->nullable()->after('contains');
            $table->string('e_sewingType')->nullable()->after('sewingType');
            $table->string('e_haveEster')->nullable()->after('haveEster');
            $table->string('e_kindOfEster')->nullable()->after('kindOfEster');
            $table->string('e_washable')->nullable()->after('washable');
            $table->string('e_description')->nullable()->after('description');
        });
        Schema::table('tablecloths', function (Blueprint $table) {
            $table->string('e_dimensions')->nullable()->after('dimensions');
            $table->string('e_weight')->nullable()->after('weight');
            $table->string('e_kind')->nullable()->after('kind');
            $table->string('e_contains')->nullable()->after('contains');
            $table->string('e_sewingType')->nullable()->after('sewingType');
            $table->string('e_haveEster')->nullable()->after('haveEster');
            $table->string('e_kindOfEster')->nullable()->after('haveEster');
            $table->string('e_washable')->nullable()->after('washable');
            $table->string('e_description')->nullable()->after('description');
            $table->string('e_uses')->nullable()->after('uses');
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
            $table->dropColumn('e_dimensions');
            $table->dropColumn('e_weight');
            $table->dropColumn('e_kind');
            $table->dropColumn('e_contains');
            $table->dropColumn('e_sewingType');
            $table->dropColumn('e_haveEster');
            $table->dropColumn('e_kindOfEster');
            $table->dropColumn('e_description');
            $table->dropColumn('e_washable');
        });
        Schema::table('fabrics', function (Blueprint $table) {
            $table->dropColumn('e_dimensions');
            $table->dropColumn('e_weight');
            $table->dropColumn('e_kind');
            $table->dropColumn('e_washable');
            $table->dropColumn('e_description');
        });
        Schema::table('pillows', function (Blueprint $table) {
            $table->dropColumn('e_dimensions');
            $table->dropColumn('e_weight');
            $table->dropColumn('e_kind');
            $table->dropColumn('e_description');
        });
        Schema::table('prayermats', function (Blueprint $table) {
            $table->dropColumn('e_dimensions');
            $table->dropColumn('e_weight');
            $table->dropColumn('e_kind');
            $table->dropColumn('e_contains');
            $table->dropColumn('e_sewingType');
            $table->dropColumn('e_haveEster');
            $table->dropColumn('e_kindOfEster');
            $table->dropColumn('e_washable');
            $table->dropColumn('e_description');
        });
        Schema::table('tablecloths', function (Blueprint $table) {
            $table->dropColumn('e_dimensions');
            $table->dropColumn('e_weight');
            $table->dropColumn('e_kind');
            $table->dropColumn('e_contains');
            $table->dropColumn('e_sewingType');
            $table->dropColumn('e_haveEster');
            $table->dropColumn('e_kindOfEster');
            $table->dropColumn('e_washable');
            $table->dropColumn('e_description');
            $table->dropColumn('e_uses');
        });
    }
}
