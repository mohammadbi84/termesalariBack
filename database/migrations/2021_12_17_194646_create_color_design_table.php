<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_design', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_id')->nullable()->index('design_id');
            $table->unsignedBigInteger('color_id')->nullable()->index('color_id');
            $table->timestamps();

            $table->foreign('design_id')
                ->references('id')
                ->on('designs')
                ->onDelete('cascade');

            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('color_design', function (Blueprint $table) {
            //
        });
    }
}
