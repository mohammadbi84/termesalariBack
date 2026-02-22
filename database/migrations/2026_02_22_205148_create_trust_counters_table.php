<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrustCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trust_counters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trust_section_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('title_fa')->nullable();
            $table->string('title_en')->nullable();

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
        Schema::dropIfExists('trust_counters');
    }
}
