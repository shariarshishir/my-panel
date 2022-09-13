<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsBusinessProfileVerifiedToBusinessProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_profiles', function (Blueprint $table) {
            $table->text('is_business_profile_verified')->nullable()->after('number_of_outlets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_profiles', function (Blueprint $table) {
            $table->dropColumn(['is_business_profile_verified']);
        });
    }
}
