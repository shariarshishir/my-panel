<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeOfProFormaAdvisingBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_forma_advising_banks', function (Blueprint $table) {
            $table->string("bank_name")->nullable()->change();
            $table->string("branch_name")->nullable()->change();
            $table->string("bank_address")->nullable()->change();
            $table->string("swift_code")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_forma_advising_banks', function (Blueprint $table) {
            //
        });
    }
}
