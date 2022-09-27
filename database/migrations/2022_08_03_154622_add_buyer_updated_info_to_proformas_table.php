<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyerUpdatedInfoToProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->string('updated_buyer_name')->nullable()->after('total_invoice_amount_with_merchant_assistant');//
            $table->string('updated_buyer_email')->nullable()->after('updated_buyer_name');//
            $table->string('updated_buyer_shipping_address')->nullable()->after('updated_buyer_email');//
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
            $table->dropColumn(['updated_buyer_name']);
            $table->dropColumn(['updated_buyer_email']);
            $table->dropColumn(['updated_buyer_shipping_address']);
        });
    }
}
