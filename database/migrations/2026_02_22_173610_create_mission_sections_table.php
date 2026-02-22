<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title_fa')->nullable();
            $table->text('description_fa')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_en')->nullable();
            $table->string('video_path')->nullable();
            $table->string('video_cover')->nullable();
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
        Schema::dropIfExists('mission_sections');
    }
}
