<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("priceable_id");
            $table->string("priceable_type");
            $table->string("local");
            $table->unsignedBigInteger("price")->index("price")->comment('قیمت');
            $table->string('offType','20')->default(0)->nullable()->comment('نوع تخفیف');
            $table->unsignedBigInteger('offPrice')->nullable()->comment('مقدار تخفیف');
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
        Schema::dropIfExists('prices');
    }
}
