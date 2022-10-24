<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('blogs', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug')->nullable();
			$table->mediumText('source')->nullable();
            $table->string('author_name',150)->nullable();
            $table->text('author_note')->nullable();
            $table->text('author_img')->nullable();
			$table->string('photo_credit',100)->nullable();
            $table->mediumText('details');
            $table->string('feature_image')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('cascade');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('blogs');
    }
}
