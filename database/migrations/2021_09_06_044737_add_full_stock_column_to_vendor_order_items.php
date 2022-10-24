<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullStockColumnToVendorOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_order_items', function (Blueprint $table) {
            $table->boolean('full_stock')->default(false)->after('order_modification_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_order_items', function (Blueprint $table) {
            $table->dropColumn('full_stock');
        });
    }
}
