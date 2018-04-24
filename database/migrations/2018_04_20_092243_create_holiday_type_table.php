<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('holiday_id')->index()->unsigned();
            $table->integer('type_id')->index()->unsigned();
        });

        Schema::table('holiday_type', function(Blueprint $table) {
            $table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('cascade');;
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_type');
    }
}
