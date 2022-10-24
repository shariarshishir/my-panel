<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('vendor_orders');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->integer('overall_rating')->default('0');
            $table->integer('communication_rating')->default('0');
            $table->integer('ontime_delivery_rating')->default('0');
            $table->integer('sample_support_rating')->default('0');
            $table->integer('product_quality_rating')->default('0');
            $table->text('experience')->nullable();
            $table->string('ip_address');
            $table->string('user_agent');
            $table->tinyInteger('state')->default('1');
            $table->unsignedBigInteger('created_by');
            $table->softDeletes();
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
        Schema::dropIfExists('vendor_reviews');
    }
}
