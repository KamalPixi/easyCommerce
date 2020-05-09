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
            $table->unsignedBigInteger('order_master_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->double('unit_sale_price');
            $table->double('subtotal_price');

            $table->boolean('has_discount')->default(false);
            $table->string('discount_type')->nullable();
            $table->double('discount_fixed_price')->nullable();
            $table->double('discount_percent')->nullable();

            $table->double('total_sale_price');
            $table->timestamps();

            $table->foreign('order_master_id')->references('id')->on('order_masters');
            $table->foreign('product_id')->references('id')->on('products');
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
