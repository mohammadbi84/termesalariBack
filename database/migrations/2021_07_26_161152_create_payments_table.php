<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('order_id');
            $table->string('tracing_code',100)->nullable();
            $table->timestamp('date')->nullable();
            $table->unsignedBigInteger('price');
            $table->string('transaction_id',40)->nullable();
            $table->string('res_code',10)->nullable();
            $table->string('ref_id',50)->nullable();
            $table->string('saleReferenceId',50)->nullable()->comment('شماره تراکنش بعد از پرداخت موفق جهت پیگیری');
            $table->string('description',300)->nullable();
            $table->timestamps();

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods')
                ->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
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
        Schema::dropIfExists('payments');
    }
}
