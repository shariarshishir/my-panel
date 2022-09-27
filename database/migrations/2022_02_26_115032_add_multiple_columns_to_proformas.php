<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnsToProformas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->unsignedBigInteger('business_profile_id')->nullable()->after('buyer_id');
            $table->unsignedInteger('payment_term_id')->nullable()->after('payment_within');
            $table->unsignedInteger('shipment_term_id')->nullable()->after('payment_term_id');
            $table->text('shipping_address')->nullable()->after('shipment_term_id');
            $table->string('forwarder_name')->nullable()->after('shipping_address');
            $table->text('forwarder_address')->nullable()->after('forwarder_name');
            $table->string('payable_party')->nullable()->after('forwarder_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->dropColumn(['business_profile_id', 'payment_term','shipment_term','shipping_address','forwarder_name','forwarder_address','payable_party']);
        });
    }
}
