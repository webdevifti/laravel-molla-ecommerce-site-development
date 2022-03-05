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
        Schema::create('billing_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('customer_company_name')->nullable();
            $table->string('customer_country');
            $table->string('street_address');
            $table->string('appertment_others');
            $table->string('town_city');
            $table->string('state_country');
            $table->integer('zip_code');
            $table->text('order_notes')->nullable();
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
        Schema::dropIfExists('billing_infos');
    }
};
