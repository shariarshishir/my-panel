<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaCheckedMerchantAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_checked_merchant_assistances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proforma_id');
            $table->unsignedBigInteger('merchant_assistance_id');
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
        Schema::dropIfExists('proforma_checked_merchant_assistances');
    }
}
