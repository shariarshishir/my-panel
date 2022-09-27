<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSameAsOfficeAddressColumnToCompanyOverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_overviews', function (Blueprint $table) {
            $table->boolean('same_as_office_adrs')->default(0)->after('factory_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_overviews', function (Blueprint $table) {
            $table->dropColumn('same_as_office_adrs');
        });
    }
}
