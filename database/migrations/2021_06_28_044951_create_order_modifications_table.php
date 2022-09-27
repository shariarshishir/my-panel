<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_modifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_modification_request_id');
            // $table->foreign('order_modification_request_id')->references('id')->on('order_modification_requests');
            $table->string('product_sku');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('colors_sizes')->nullable();
            $table->integer('quantity');
            $table->float('unit_price',10,2);
            $table->float('total_price',10,2);
            $table->tinyInteger('state')->default(0);
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
        Schema::dropIfExists('order_modifications');
    }
}
