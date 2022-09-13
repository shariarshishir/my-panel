<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSpotlightToBusinessProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_profiles', function (Blueprint $table) {
            $table->text('is_spotlight')->nullable()->after('profile_verified_by_admin');
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
            $table->dropColumn(['is_spotlight']);
        });
    }
}
