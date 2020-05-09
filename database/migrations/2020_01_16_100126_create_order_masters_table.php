<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shipping_method_id');
            $table->unsignedBigInteger('shpping_address_id')->nullable();
            $table->unsignedBigInteger('billing_address_id')->nullable();
            $table->integer('total_qty');
            $table->integer('shipping_cost');
            $table->integer('total_price');
            $table->string('status')->default('pending');
            $table->boolean('is_new')->default('1');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shpping_address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_masters');
    }
}
