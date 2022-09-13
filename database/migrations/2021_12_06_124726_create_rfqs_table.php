<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->integer('rfq_deal_status')->default(0);
            $table->unsignedInteger('category_id');
            $table->string('title');
            $table->string('quantity')->nullable();
            $table->string('unit');
            $table->string('unit_price')->nullable();
            $table->string('industry')->default('apparel');
            $table->string('destination')->nullable();
            $table->string('payment_method')->nullable();
            $table->dateTime('delivery_time')->nullable();
            $table->text('short_description')->nullable();
            $table->text('full_specification')->nullable();
            $table->string('status')->nullable();
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfqs');
    }
}
