<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('vendor_orders');
            $table->string('product_sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('unit_price',8,2)->nullable();
            $table->float('price',10,2)->nullable();
            $table->float('copyright_price',8,2)->nullable();
            $table->text('colors_sizes')->nullable();
            $table->unsignedBigInteger('order_modification_id')->nullable();
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
        Schema::dropIfExists('vendor_order_items');
    }
}
