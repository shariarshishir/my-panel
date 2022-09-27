<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_type')->nullable()->after('user_type');
            $table->boolean('is_supplier')->default(false)->after('business_type');
            $table->string('designation')->nullable()->after('is_supplier');
            $table->text('linkedin_profile')->nullable()->after('designation');
            $table->text('company_website')->nullable()->after('linkedin_profile');

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
            $table->dropColumn(['business_type', 'is_supplier','designation','linkedin_profile','company_website']);
        });
    }
}
