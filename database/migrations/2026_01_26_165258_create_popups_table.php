<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popups', function (Blueprint $table) {
            $table->id();

            // محتوای فارسی
            $table->string('title_fa');
            $table->text('description_fa')->nullable();

            // محتوای انگلیسی
            $table->string('title_en')->nullable();
            $table->text('description_en')->nullable();

            // لینک هدایت
            $table->string('link')->nullable();

            // وضعیت
            $table->boolean('is_active')->default(false);

            // بازه زمانی نمایش
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

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
        Schema::dropIfExists('popups');
    }
}
