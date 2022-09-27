<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderSampleAvailabilityColumnToManufactureProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('products', function (Blueprint $table) {
            $table->tinyInteger('gender')->nullable()->after('sizes');
            $table->boolean('sample_availability')->default(false)->after('gender');
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
            $table->dropColumn(['gender','sample_availability']);
        });
    }
}
