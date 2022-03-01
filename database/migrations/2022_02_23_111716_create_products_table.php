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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('sub_category')->nullable();
            $table->string('product_title');
            $table->string('product_slug');
            $table->integer('product_sku');
            $table->integer('discount')->nullable();
            $table->integer('regular_price');
            $table->integer('selling_price');
            $table->string('product_preview_img')->nullable();
            $table->longText('description');
            $table->longText('addition_information');
            $table->text('shipping_and_return_condition');
            $table->integer('quantity');
            $table->integer('status')->default('1');
            $table->integer('added_by');
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
        Schema::dropIfExists('products');
    }
};
