<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedByAdminToVendorOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by_admin')->after('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_orders', function (Blueprint $table) {
            $table->dropColumn(['approved_by_admin']);
        });
    }
}
