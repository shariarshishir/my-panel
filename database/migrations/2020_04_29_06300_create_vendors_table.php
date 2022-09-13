<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            //user_id is used here as foreign key of user table
            $table->unsignedBigInteger('user_id');
            $table->string('vendor_uid')->nullable();
            //vendor name is kept null bacasue buyer can fill or keep it empty
            $table->string('vendor_name')->nullable();
            $table->string('vendor_address')->nullable();
            $table->string('vendor_ownername')->nullable();
            $table->string('vendor_country')->nullable();
            $table->string('vendor_type')->nullable();
            $table->foreignId('vendor_mainproduct')->nullable();
            $table->string('vendor_totalemployees')->nullable();
            $table->string('vendor_yearest')->nullable();
            $table->string('vendor_certification')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('vendors');
    }
}
