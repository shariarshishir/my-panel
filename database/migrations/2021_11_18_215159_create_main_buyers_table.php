<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_buyers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('business_profile_id')->nullable();
                $table->string('title')->nullable();
                $table->text('short_description')->nullable();
                $table->text('image')->nullable();
                $table->unsignedInteger('created_by');
                $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('main_buyers');
    }
}
