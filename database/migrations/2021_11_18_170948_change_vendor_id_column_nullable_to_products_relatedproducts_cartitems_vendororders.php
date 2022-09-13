<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVendorIdColumnNullableToProductsRelatedproductsCartitemsVendororders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['products', 'related_products', 'cart_items', 'vendor_orders','order_modification_requests'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
               $table->unsignedBigInteger('vendor_id')->nullable()->change();
            });
       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


    }
}
