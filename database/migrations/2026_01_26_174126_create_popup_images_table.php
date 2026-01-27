<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('popup_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->integer('order')->default(0);
            $table->integer('duration')->default(5)->comment('seconds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('popup_images');
    }
}
