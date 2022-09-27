<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationMessageToBusinessProfileVerificationsRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_profile_verifications_request', function (Blueprint $table) {
            $table->text('verification_message')->nullable()->after('business_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_profile_verifications_request', function (Blueprint $table) {
            $table->dropColumn(['verification_message']);
        });
    }
}
