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
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->string('name');
            $table->string('sku');
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->tinyInteger('product_type');
            $table->string('attribute')->nullable();
            $table->tinyInteger('is_featured');
            $table->tinyInteger('is_new_arrival');
            $table->tinyInteger('state');
            $table->text('colors_sizes')->nullable();
            $table->integer('moq')->nullable();
            $table->float('copyright_price',8,2)->nullable();
            $table->text('description');
            $table->text('additional_description')->nullable();
            $table->integer('availability')->nullable();
            $table->boolean('sold')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('products');
    }
}
