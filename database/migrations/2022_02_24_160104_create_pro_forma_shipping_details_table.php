<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProFormaShippingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_forma_shipping_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proforma_id');
            $table->integer('shipping_details_method');
            $table->integer('shipping_details_type');
            $table->integer('shipping_details_uom');
            $table->float('shipping_details_per_uom_price',10,2)->default(0.00);
            $table->integer('shipping_details_qty');
            $table->float('shipping_details_total', 10, 2)->defalut(0.00);
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
        Schema::dropIfExists('pro_forma_shipping_details');
    }
}
