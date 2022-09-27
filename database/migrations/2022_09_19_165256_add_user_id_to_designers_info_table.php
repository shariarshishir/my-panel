<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToDesignersInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designers_info', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->after('id');//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designers_info', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
    }
}
