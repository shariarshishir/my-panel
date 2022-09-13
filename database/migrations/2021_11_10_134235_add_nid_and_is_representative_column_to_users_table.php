<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNidAndIsRepresentativeColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nid_passport')->nullable()->after('fcm_token');
            $table->boolean('is_representative')->default(false)->after('fcm_token');
            $table->string('company_name')->nullable()->after('fcm_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nid_passport');
            $table->dropColumn('is_representative');
            $table->dropColumn('company_name');
        });
    }
}
