<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicFiledsToModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name_en');
            $table->text('address_ar')->nullable()->after('address_en');
        });
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
            $table->text('body_ar')->nullable()->after('body_en');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('ar_title')->nullable()->after('e_title');
        });
        Schema::table('certificate_sections', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });
        Schema::table('colors', function (Blueprint $table) {
            $table->string('ar_color')->nullable()->after('e_color');
        });
        Schema::table('designs', function (Blueprint $table) {
            $table->string('ar_title')->nullable()->after('e_title');
        });
        Schema::table('generations', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name_en');
            $table->string('pretext_ar')->nullable()->after('pretext_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });
        Schema::table('mission_counters', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
        });
        Schema::table('mission_sections', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });
        Schema::table('popups', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });
        Schema::table('product_authenticity_sections', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });
        Schema::table('trust_sections', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });
        Schema::table('trust_counters', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('name_ar');
            $table->dropColumn('address_ar');
        });
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropColumn('title_ar');
            $table->dropColumn('body_ar');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('ar_title');
        });
        Schema::table('certificate_sections', function (Blueprint $table) {
            $table->dropColumn('title_ar');
            $table->dropColumn('description_ar');
        });
        Schema::table('colors', function (Blueprint $table) {
            $table->dropColumn('ar_color');
        });
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('ar_title');
        });
        Schema::table('generations', function (Blueprint $table) {
            $table->dropColumn('name_ar');
            $table->dropColumn('pretext_ar');
            $table->dropColumn('description_ar');
        });
        Schema::table('mission_counters', function (Blueprint $table) {
            $table->dropColumn('title_ar');
        });
        Schema::table('mission_sections', function (Blueprint $table) {
            $table->dropColumn('title_ar');
            $table->dropColumn('description_ar');
        });
        Schema::table('popups', function (Blueprint $table) {
            $table->dropColumn('title_ar');
            $table->dropColumn('description_ar');
        });
        Schema::table('product_authenticity_sections', function (Blueprint $table) {
            $table->dropColumn('title_ar');
            $table->dropColumn('description_ar');
        });
        Schema::table('trust_sections', function (Blueprint $table) {
            $table->dropColumn('title_ar');
            $table->dropColumn('description_ar');
        });
        Schema::table('trust_counters', function (Blueprint $table) {
            $table->dropColumn('title_ar');
        });
    }
}
