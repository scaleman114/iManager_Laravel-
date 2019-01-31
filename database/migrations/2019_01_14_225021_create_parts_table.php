<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->decimal('cost',10,2)->nullable();
            $table->decimal('price',10,2);
            $table->float('count',8,2)->nullable();
            $table->string('supplier_no')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('stock_item')->default('1');
            $table->integer('supplier_id')->nullable();
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
        Schema::dropIfExists('parts');
    }
}