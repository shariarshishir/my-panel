<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessProfileVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_profile_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_profile_id')->nullable();
            $table->tinyInteger('company_overview')->default(0);
            $table->tinyInteger('capacity_and_machineries')->default(0);
            $table->tinyInteger('business_terms')->default(0);
            $table->tinyInteger('sampling')->default(0);
            $table->tinyInteger('special_customizations')->default(0);
            $table->tinyInteger('sustainability_commitments')->default(0);
            $table->tinyInteger('production_capacity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_profile_verifications');
    }
}
