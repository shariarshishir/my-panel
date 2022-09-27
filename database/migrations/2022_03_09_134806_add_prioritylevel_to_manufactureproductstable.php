<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrioritylevelToManufactureproductstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('products', function (Blueprint $table) {
            $table->tinyInteger('priority_level')->after('sample_availability')->nullable()->default(4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('products', function (Blueprint $table) {
            $table->dropColumn('priority_level');
        });
    }
}
