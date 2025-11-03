<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_cards', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('order_id')->index('order_id')->nullable();
            $table->string('code');
            $table->string('type_scope',20)->default('private')->comment('وضعیت محدوده دسترسی: عمومی یا خصوصی');
            $table->string('count_usable',40)->default(1)->comment('کد تخفیف اگر عمئمی است چند تفر می توانند از آن استفاده کنن.');
            $table->string('type_amount',20)->comment('نوع تخفیف: درصدی یا مقدار ثابت');
            $table->string('amount',40);
            $table->timestamp('start_date');
            $table->timestamp('expire_date');
            $table->boolean('is_gifted')->default(0)->comment('به کسی هدیه شده؟ یا نه؟');
            $table->timestamps();
            
            // $table->foreign('order_id')
            //     ->references('id')
            //     ->on('orders')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_cards');
    }
}
