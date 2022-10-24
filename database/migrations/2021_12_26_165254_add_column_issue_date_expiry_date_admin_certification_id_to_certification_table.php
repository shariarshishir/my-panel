<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIssueDateExpiryDateAdminCertificationIdToCertificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certifications', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_certification_id')->nullable()->after('id');
            $table->dateTime('issue_date')->nullable()->after('id');
            $table->dateTime('expiry_date')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certifications', function (Blueprint $table) {
            $table->dropColumn('admin_certification_id');
            $table->dropColumn('issue_date');
            $table->dropColumn('expiry_date');
        });
    }
}
