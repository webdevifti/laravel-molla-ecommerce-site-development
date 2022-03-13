<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_firstname')->nullable();
            $table->string('customer_lastname')->nullable();
            $table->string('customer_username');
            $table->string('customer_email');
            $table->string('customer_photo')->nullable();
            $table->string('customer_password');
            $table->string('customer_phone_number')->nullable();
            $table->string('customer_status')->default('1');
            $table->string('verification_code');
            $table->integer('social_login_id')->nullable();
            $table->string('is_verified')->default('not_verified');
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
        Schema::dropIfExists('customers');
    }
};
