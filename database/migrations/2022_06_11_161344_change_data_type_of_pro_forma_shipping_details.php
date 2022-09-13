<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeOfProFormaShippingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_forma_shipping_details', function (Blueprint $table) {
            $table->string("shipping_details_per_uom_price")->nullable()->change();
            $table->string("shipping_details_qty")->nullable()->change();
            $table->string("shipping_details_total")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_forma_shipping_details', function (Blueprint $table) {
            //
        });
    }
}
