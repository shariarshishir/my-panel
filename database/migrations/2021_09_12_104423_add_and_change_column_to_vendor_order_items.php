<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndChangeColumnToVendorOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_order_items', function (Blueprint $table) {
            $table->renameColumn('order_modification_id', 'order_modification_req_id');
            $table->float('discount')->after('unit_price')->nullable();

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
            $table->renameColumn('order_modification_req_id', 'order_modification_id');
            $table->dropColumn('discount');
        });
    }
}
