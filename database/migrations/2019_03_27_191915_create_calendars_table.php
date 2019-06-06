<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cglobal_id');
            $table->bigInteger('user_id');
            $table->bigInteger('for_user_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('title', 50);
            $table->string('contentFull', 250)->nullable();
            $table->tinyInteger('allDay')->default(1);
            $table->string('class', 10);
            $table->tinyInteger('status_id')->default(1);
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
