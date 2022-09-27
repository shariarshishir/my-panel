<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('performa_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->integer('unit');
            $table->float('unit_price',10,2)->default(0.00);
            $table->string('price_unit');
            $table->float('tax', 10, 2)->default(0.00);
            $table->float('total_price', 10, 2)->defalut(0.00);
            $table->float('tax_total_price', 10, 2)->default(0.00);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proforma_products');
    }
}
