<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToBusinessProfileVerifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_profile_verifications', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->after('production_capacity');
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
            $table->dropColumn(['created_by']);
        });
    }
}
