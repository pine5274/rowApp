<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rows', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->time('date_time');
            $table->string('boat_name');
            $table->dateTime('on_the_water');
            $table->dateTime('off_the_water');
            $table->string('lower_limit_area');
            $table->string('upper_limit_area');
            $table->string('others');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rows');
    }
}
