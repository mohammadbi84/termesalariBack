<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('family');
            $table->string('nationalCode')->nullable();
            $table->boolean('isForeign')->default(0)->nullable();
            $table->string('mobile');
            $table->timestamp('birthday')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('shaba_number',24)->nullable();
            $table->boolean('send_newsletter')->default(1);
            $table->rememberToken();
            $table->string('role')->default('user');
            $table->boolean('isActive')->default(1);
            $table->string('image','150')->nullable()->default("avatar1.png");
            $table->string('companyName','255')->nullable()->comment("نام شرکت");
            $table->string('companyEconomyID','12')->nullable()->comment("کد اقتصدی");
            $table->string('companyNationalID','11')->nullable()->comment("شناسه ملی");
            $table->string("companyRegistrationID",'25')->nullable()->comment("شناسه ثبت");
            $table->unsignedBigInteger('city_id')->nullable()->index('city_id');
            $table->unsignedBigInteger('subcity_id')->nullable()->index('subcity_id');
            $table->string("companyTel",'50')->nullable();
            $table->string("companySite",'50')->nullable();
            $table->string("mobile_forget_password_code",'20')->nullable()->comment("کد هنگان فراموشی رمز عبور از طریق موبایل");
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');

            $table->foreign('subcity_id')
                ->references('id')
                ->on('subcities')
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
        Schema::dropIfExists('users');
    }
}
