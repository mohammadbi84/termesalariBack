<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->string('name','50');
            $table->string('family','100')->index('family');
            $table->string('mobile','20');
            $table->string('tel','15');
            $table->unsignedBigInteger('city_id')->index('city_id');
            $table->unsignedBigInteger('subcity_id')->index('subcity_id');
            $table->text('address');
            $table->string('houseId','20')->nullable()->comment('پلاک');
            $table->string('zipcode','20');
            $table->boolean('visibility')->default(1);
            $table->string('lat','50')->nullable();
            $table->string('lan','50')->nullable();
            // $table->boolean('default')->comment('گیرنده پیش فرض');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');

            $table->foreign('subcity_id')
                ->references('id')
                ->on('subcities')
                ->onDelete('cascade');  
                  
            $table->softDeletes();
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
        Schema::dropIfExists('recipients');
    }
}
