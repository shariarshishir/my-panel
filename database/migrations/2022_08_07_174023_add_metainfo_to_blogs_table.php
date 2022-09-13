<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetainfoToBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('feature_image');//
            $table->string('meta_description')->nullable()->after('meta_title');//
            $table->string('meta_image')->nullable()->after('meta_description');//
            $table->string('meta_type')->nullable()->after('meta_image');//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['meta_title']);
            $table->dropColumn(['meta_description']);
            $table->dropColumn(['meta_image']);
            $table->dropColumn(['meta_type']);
        });
    }
}
