<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnFieldsToSlideshowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slideshows', function (Blueprint $table) {
            $table->string('e_title')->nullable()->after('title');
            $table->string('ar_title')->nullable()->after('e_title');

            $table->text('e_description')->nullable()->after('description');
            $table->text('ar_description')->nullable()->after('e_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slideshows', function (Blueprint $table) {
            $table->dropColumn([
                'e_title',
                'ar_title',
                'e_description',
                'ar_description',
            ]);
        });
    }
}
