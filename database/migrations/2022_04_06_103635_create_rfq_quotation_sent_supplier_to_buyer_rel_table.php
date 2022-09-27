<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqQuotationSentSupplierToBuyerRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_quotation_sent_supplier_to_buyer_rel', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_id');
            $table->unsignedBigInteger('business_profile_id')->nullable();
            $table->float('offer_price', 8, 2);      
            $table->string('offer_price_unit'); 
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
        Schema::dropIfExists('rfq_quotation_sent_supplier_to_buyer_rel');
    }
}
