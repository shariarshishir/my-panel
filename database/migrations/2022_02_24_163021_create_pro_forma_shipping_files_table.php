<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProFormaShippingFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_forma_shipping_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proforma_id');
            $table->string('shipping_details_file_names')->nullable();
            $table->text('shipping_details_files')->nullable();
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
        Schema::dropIfExists('pro_forma_shipping_files');
    }
}
