<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('business_name');
            $table->string('location')->nullable();
            $table->tinyInteger('business_type');
            $table->boolean('has_representative');
            $table->string('industry_type');
            $table->unsignedBigInteger('business_category_id')->nullable();
            $table->unsignedBigInteger('representative_user_id')->nullable();
            $table->string('number_of_factories')->nullable();
            $table->string('number_of_outlets')->nullable();
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
        Schema::dropIfExists('business_profiles');
    }
}
