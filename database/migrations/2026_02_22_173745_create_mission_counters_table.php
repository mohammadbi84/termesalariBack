<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_section_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('title_fa');
            $table->string('title_en');
            $table->bigInteger('number')->default(0);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('mission_counters');
    }
}
