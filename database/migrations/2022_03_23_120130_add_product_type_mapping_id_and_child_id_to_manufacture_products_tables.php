<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductTypeMappingIdAndChildIdToManufactureProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_type_mapping_id')->after('industry')->nullable();
            $table->string('product_type_mapping_child_id')->after('product_type_mapping_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('products', function (Blueprint $table) {
            $table->dropColumn(['product_type_mapping_id', 'product_type_mapping_child_id']);
        });
    }
}
