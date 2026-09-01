<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnglishFieldsToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('image')->nullable()->after('id');
            $table->boolean('is_active')->default(true)->nullable()->after('id');
            $table->string('e_title')->nullable()->after('title');
            $table->string('ar_title')->nullable()->after('e_title');
            $table->longText('e_body')->nullable()->after('body');
            $table->longText('ar_body')->nullable()->after('e_body');
            $table->unsignedInteger('views')->default(0)->after('e_body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['e_title', 'ar_title','e_body','ar_body','is_active','views','image']);
        });
    }
}
