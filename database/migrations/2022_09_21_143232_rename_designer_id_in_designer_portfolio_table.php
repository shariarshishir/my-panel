<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDesignerIdInDesignerPortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designer_portfolio', function (Blueprint $table) {
            $table->renameColumn('designer_id', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designer_portfolio', function (Blueprint $table) {
            $table->renameColumn('user_id', 'designer_id');
        });
    }
}
