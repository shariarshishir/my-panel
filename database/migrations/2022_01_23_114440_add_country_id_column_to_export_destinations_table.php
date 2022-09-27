<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryIdColumnToExportDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('export_destinations', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable()->after('business_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('export_destinations', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
    }
}
