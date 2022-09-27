<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->string('cart_row_id');
            $table->string('product_sku');
            $table->string('product_type');
            $table->string('cookie_identifier');
            $table->string('name');
            $table->integer('quantity');
            $table->float('unit_price',10,2);
            $table->float('total_price',10,2);
            $table->float('copyright_price', 8, 2)->nullable();
            $table->string('image');
            $table->text('color_attr')->nullable();
            $table->unsignedBigInteger('order_modification_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
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
        Schema::dropIfExists('cart_items');
    }
}
