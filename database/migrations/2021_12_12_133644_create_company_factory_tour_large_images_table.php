<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyFactoryTourLargeImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_factory_tour_large_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_factory_tour_id')->nullable();
            $table->text('factory_large_image')->nullable();
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
        Schema::dropIfExists('company_factory_tour_large_images');
    }
}
