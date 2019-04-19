<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cglobals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('moment');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('type_contact_id');
            $table->smallInteger('repeater');
            $table->smallInteger('type_motive');
            $table->smallInteger('type_motive_id');
            $table->smallInteger('required_time');
            $table->smallInteger('type_compromise_id');
            $table->smallInteger('traser');
            $table->string('note',500)->nullable();
            $table->integer('status_id')->default(1);
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
        Schema::dropIfExists('cglobals');
    }
}
