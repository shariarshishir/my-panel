<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProFormaAdvisingBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_forma_advising_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proforma_id');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('bank_address');
            $table->string('swift_code');
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
        Schema::dropIfExists('pro_forma_advising_banks');
    }
}
