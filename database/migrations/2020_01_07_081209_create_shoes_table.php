<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',100)->index('code')->comment('کد محصول');
            $table->string('title','150')->index('title')->comment('عنوان');
            $table->unsignedBigInteger('design_id')->index('design_id')->comment('نام طرح');
            $table->unsignedBigInteger('design_color_id')->index('design_color_id')->default(0)->comment('رنگ محصول');
            $table->string('dimensions','100')->comment('ابعاد');
            $table->string('sizesOf','50')->comment('سایزهای موجود');
            $table->string('weight','50')->comment('وزن تقریبی');
            $table->string('type','50')->index('type')->comment('نوع');
            $table->string('kind','50')->comment('جنس');
            $table->string('gender','20')->index('gender')->comment('مناسب برای');
            $table->string('kindOfOver','50')->comment('جنس رویه کفش');
            $table->string('kindOfUnder','50')->comment('جنس زیره کفش');
            $table->string('washable','20')->comment('قابلیت شستشو');
            $table->text('uses')->comment('موارد استفاده');
            $table->unsignedBigInteger('quantity')->default(0)->comment('موجود در انبار');
            $table->unsignedSmallInteger('grade')->index('garde')->comment('امتیاز');
            // $table->unsignedBigInteger('price')->index('price')->comment('قیمت');
            // $table->string('offType','20')->default("درصد")->nullable()->comment('نوع تخفیف')->default('percent');
            // $table->unsignedBigInteger('offPrice')->default(0)->comment('مقدار تخفیف');
            $table->text('description')->comment('توضیحات بیشتر');
            $table->timestamps();
            $table->foreign('design_id')
                ->references('id')
                ->on('designs')
                ->onDelete('cascade');
            $table->foreign('design_color_id')
                ->references('id')
                ->on('design_colors')
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
        Schema::dropIfExists('shoes');
    }
}
