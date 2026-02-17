<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();

            $table->string('name_fa'); // نام نماینده
            $table->string('name_en'); // نام نماینده
            $table->string('image')->nullable(); // عکس اصلی نماینده

            $table->text('address_fa'); // آدرس کامل
            $table->text('address_en'); // آدرس کامل
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->unsignedBigInteger('city_id');

            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();

            $table->json('social_links')->nullable();

            $table->integer('sort')->default(0);

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
        Schema::dropIfExists('agencies');
    }
}
