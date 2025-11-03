<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code','70')->index('code')->unique();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('discount_card_id')->nullable();

            // $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger("orderable_id")->comment('مربوط به پرداخت اینترنتی و کارت به کارت');
            $table->string("orderable_type")->comment('مربوط به پرداخت اینترنتی و کارت به کارت');
            // $table->timestamp('date');
            $table->unsignedBigInteger('postPrice');
            $table->string('post_code','50')->nullable()->unique()->comment("کد تخصیص یافته به مرسوله از اداره پست");
            $table->timestamps('post_date')->nullable()->comment('تاریخ پست سفارش');
            $table->string('local','20');
            $table->boolean('status')->default(0)->comment('صفر=بررسی نشده یک=تایید و ارسال دو=کنسل');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('recipient_id')
                ->references('id')
                ->on('recipients')
                ->onDelete('cascade');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->foreign('discount_card_id')
                ->references('id')
                ->on('discount_cards')
                ->onDelete('cascade');
              
            // $table->foreign('payment_method_id')
            //     ->references('id')
            //     ->on('payment_methods')
            //     ->onDelete('cascade');

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
        Schema::dropIfExists('orders');
    }
}
