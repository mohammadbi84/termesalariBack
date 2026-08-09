<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazings', function (Blueprint $table) {
            $table->id();
            $table->morphs('productable');
            $table->date('start_date');
            $table->date('end_date');

            $table->integer('max_sale')->default(0);
            $table->integer('sold')->default(0);
            $table->integer('discount')->default(0);

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
        Schema::dropIfExists('amazings');
    }
}
