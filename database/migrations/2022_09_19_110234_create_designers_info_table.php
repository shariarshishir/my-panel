<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignersInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designers_info', function (Blueprint $table) {
            $table->id();
            $table->text('designer_location')->nullable();
            $table->unsignedInteger('designer_asking_price')->nullable();
            $table->string('designer_nationality')->nullable();
            $table->unsignedInteger('designer_experience')->nullable();
            $table->unsignedInteger('designer_worked_with')->nullable();
            $table->unsignedInteger('designer_completed_task')->nullable();
            $table->unsignedInteger('designer_response_time')->nullable();
            $table->text('designer_about_me')->nullable();
            $table->text('designer_skills')->nullable();
            $table->text('designer_certifications')->nullable();
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
        Schema::dropIfExists('designers_info');
    }
}
