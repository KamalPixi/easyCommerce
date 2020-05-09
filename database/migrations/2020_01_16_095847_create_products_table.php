<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('sku')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->double('buy_price')->nullable();
            $table->double('sale_price');
            $table->integer('stock');

            $table->boolean('has_attribute')->default(false);

            $table->boolean('has_discount')->default(false);
            $table->string('discount_type')->nullable();
            $table->double('discount_fixed_price')->nullable();
            $table->double('discount_percent')->nullable();

            $table->boolean('is_active')->default(false);
            $table->integer('viewed')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->longText('supplier_details')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
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
}
