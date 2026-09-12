<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnFieldsToMainvideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mainvideos', function (Blueprint $table) {
            $table->string('e_title')->nullable()->after('title');
            $table->string('ar_title')->nullable()->after('e_title');
            $table->string('e_cover')->nullable()->after('cover');
            $table->string('ar_cover')->nullable()->after('e_cover');
            $table->string('e_video')->nullable()->after('video');
            $table->string('ar_video')->nullable()->after('e_video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mainvideos', function (Blueprint $table) {
            $table->dropColumn([
                'e_video',
                'ar_video',
                'e_title',
                'ar_title',
                'e_cover',
                'ar_cover',
            ]);
        });
    }
}
