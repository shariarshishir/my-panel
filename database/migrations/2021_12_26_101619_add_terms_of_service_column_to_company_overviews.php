<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermsOfServiceColumnToCompanyOverviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_overviews', function (Blueprint $table) {
            $table->text('terms_of_service')->nullable()->after('factory_address');
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
            $table->dropColumn(['terms_of_service']);
        });
    }
}
