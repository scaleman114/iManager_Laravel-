<?php
use App\Enums\RepairType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('repair_cutomer');
            $table->timestamp('date');
            $table->tinyInteger('repair_type')->unsigned()->default(RepairType::Industrial);
            $table->decimal('min_charge', 10, 2)->nullable();
            $table->decimal('quoted', 10, 2)->nullable();
            $table->float('hours')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('repairs');
    }
}