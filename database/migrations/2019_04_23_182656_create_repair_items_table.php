<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('repair_id')->unsigned();
            $table->foreign('repair_id')->references('id')->on('repairs');
            $table->string('mc_type', 30);
            $table->string('serial_no', 20);
            $table->string('capacity', 10);
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
        Schema::dropIfExists('repair_items');
    }
}