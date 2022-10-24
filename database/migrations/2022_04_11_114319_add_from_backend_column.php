<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromBackendColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfq_quotation_sent_supplier_to_buyer_rel', function (Blueprint $table) {
            $table->boolean('from_backend')->default(true)->after('offer_price_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfq_quotation_sent_supplier_to_buyer_rel', function (Blueprint $table) {
            $table->dropColumn('from_backend');
        });
    }
}
