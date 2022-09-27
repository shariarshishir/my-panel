<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriresProducedAndMachineriesDetailsColumnToBusinessProfileVerificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_profile_verifications', function (Blueprint $table) {
            $table->tinyInteger('categories_produced')->default(0)->after('company_overview');
            $table->tinyInteger('machinery_details')->default(0)->after('company_overview');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_profile_verifications', function (Blueprint $table) {
            $table->dropColumn('categories_produced');
            $table->dropColumn('machinery_details');
        });
    }
}
