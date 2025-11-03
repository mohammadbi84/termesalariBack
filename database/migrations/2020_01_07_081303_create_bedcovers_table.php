<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedcoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bedcovers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',100)->index('code')->comment('کد محصول');
            $table->unsignedBigInteger('category_id')->index('category_id')->comment('نوع');
            $table->unsignedBigInteger('color_design_id')->index('color_design_id')->default(0)->comment('رنگ و طرح محصول');          
            $table->string('dimensions','500')->comment('ابعاد');
            $table->string('weight','50')->comment('وزن تقریبی');
            $table->string('kind','50')->comment('جنس');
            $table->text('contains')->comment('مشتمل بر');
            $table->string('sewingType','50')->comment('نوع دوخت');
            $table->string('haveEster','20')->comment('آستر دارد');
            $table->string('kindOfEster','50')->comment('جنس آستر');
            $table->string('washable','50')->comment('قابلیت شستشو');
            $table->unsignedBigInteger('quantity')->default(0)->comment('موجود در انبار');
            $table->text('description')->comment('توضیحات بیشتر');
            $table->boolean('visibility')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('color_design_id')
                ->references('id')
                ->on('color_design')
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
        Schema::dropIfExists('bedcovers');
    }
}
