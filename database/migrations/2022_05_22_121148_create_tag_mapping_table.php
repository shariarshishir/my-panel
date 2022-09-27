<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_mapping', function (Blueprint $table) {
            $table->bigInteger('product_tag_id')->unsigned();
            $table->bigInteger('business_mapping_id')->unsigned();
            $table->foreign('product_tag_id')->references('id')->on('product_tags')
                ->onDelete('cascade');
            $table->foreign('business_mapping_id')->references('id')->on('business_mapping_trees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_mapping');
    }
}
